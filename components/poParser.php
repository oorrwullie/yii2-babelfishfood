<?php

namespace oorrwullie\babelfishfood\components;

use Yii;
use yii\base\Component;
use oorrwullie\babelfishfood\models\PoMessages;

class poParser extends Component {

    public $translations = [];
    public $header = [];
    public $generatedPath;
    public $compiledPath;
    public $filename;

    public function fetch($path, $lang) {

	$po = file($path.$lang.$this->filename);
	$i = 0;
	$row = 0;
	$len = 0;

	foreach ($po as $line) {
	    $len++;
	    if ($line == "\n" || $line == "\r\n") {
		break;
	    }
	}

	foreach ($po as $line) {
	    if ($row < $len) {
		$row++;
		continue;
	    } else {
		if ($line == "\n" || $line == "\r\n") {
		    $i++;
		}
		if ($line[0] == '#' || substr($line,0,7) == 'msgctxt') {
		    if(!isset($model)){
			$model = new PoMessages();
			$model->id = $i;
		    }
		}
		if ($line[0] == '#') {
		    $commentId = substr($line, 2, 10);
		    if ($commentId == 'TRANSLATED') {
			$model->translated = substr($line, 14, -1);
		    } elseif ($commentId == 'TRANSLATOR') {
			$model->translator = substr($line, 14, -1);
		    } else {
			$model->comment = substr($line, 11, -1);
		    }
		}
		if (substr($line,0,7) == 'msgctxt') {
		    $category = trim(substr(trim(substr($line,7)),1,-1));
		    $model->msgctxt = $category;
		}
		if (substr($line,0,5) == 'msgid') {
		    $id = trim(substr(trim(substr($line,5)),1,-1));
		    $model->msgid = $id;
		}
		if (substr($line,0,6) == 'msgstr') {
		    $msgstr = trim(substr(trim(substr($line,6)),1,-1));
		    $model->msgstr = stripslashes($msgstr);
		    $translations[$i] = $model;
		    unset($model);
		}
	    }
	}
	return [$translations];
    }

    public function merge($generatedPo, $compiledPo) {

	foreach($generatedPo as $generatedObject) {

	    $categoryMatches = $this->_findAllByMsgctxt($compiledPo, $generatedObject->msgctxt);
	    if (!empty($categoryMatches)) {
		$compiledObject = $this->_findByMsgid($categoryMatches, $generatedObject->msgid);
		if (!empty($compiledObject)) {
		    foreach ($compiledObject as $key => $value) {
			if (substr($generatedObject->msgstr, 0, 2) == '@@') {
			    $compiledPo[$key]->msgstr = '@@' . $value->msgstr . '@@';
			} elseif (substr($value->msgstr, 0, 2) == '@@' && substr($generatedObject->msgstr, 0, 2) !== '@@') {
			    $compiledPo[$key]->msgstr = substr($value->msgstr, 2, -2);
			} elseif (!empty($generatedObject->msgstr)) {
			    $compiledPo[$key]->msgstr = $generatedObject->msgstr;
			}
		    }
		} else {
		    $compiledPo[] = $this->_newCompiledObject($generatedObject);
		}
	    } else {
		$compiledPo[] = $this->_newCompiledObject($generatedObject);
	    }
	}

	usort($compiledPo, [$this, "_cmp"]);
	return $compiledPo;
    }

    private function _cmp($a,$b) {
	if ($a->msgctxt == $b->msgctxt) {
	    return strcmp($a->msgid, $b->msgid);
	} else {
	    return strcmp($a->msgctxt, $b->msgctxt);
	}
    }

    private function _newCompiledObject($generatedObject) {

	$model = new PoMessages();

	$model->msgctxt = $generatedObject->msgctxt;
	$model->msgid = $generatedObject->msgid;
	$model->msgstr = $generatedObject->msgstr;

	return $model;
    }

    private function _findAllByMsgctxt($objects, $msgctxt) {
	return array_filter($objects, function($toCheck) use ($msgctxt) { 
	    return $toCheck->msgctxt == $msgctxt; 
	});
    }

    private function _findByMsgid($objects, $msgid) {
	return array_filter($objects, function($toCheck) use ($msgid) { 
	    return $toCheck->msgid == $msgid; 
	});
    }

    public function getGeneratedPo($lang) {
	$generatedPo = $this->fetch($this->generatedPath, $lang);
	return $generatedPo[0];
    }

    public function getCompiledPo($lang) {
	$compiledPo = $this->fetch($this->compiledPath, $lang);
	return $compiledPo[0];
    }

    public function save($lang, $translations) {
	
	$len = 0;
	$row = 0;
	$data = '';
	$file = $this->compiledPath.$lang.$this->filename;
	$po = file($file);

	foreach ($po as $line) {
	    $len++;
	    if ($line == "\n" || $line == "\r\n") {
		break;
	    }
	}

	foreach ($po as $line) {
	    if ($row < $len) {
		    $data .= $line;
		    $row++;
	    }
	}

	foreach ($translations as $translation) {
		if($translation->comment) {
		$data .= '# COMMENT: ' . $translation->comment . "\n";
		}
		if($translation->translator) {
		$data .= '# TRANSLATOR: ' . $translation->translator . "\n";
		}
		if($translation->translated) {
		$data .= '# TRANSLATED: ' . $translation->translated . "\n";
		}
		$data .= 'msgctxt "' . $translation->msgctxt . "\"\n";
		$data .= 'msgid "' . $translation->msgid . "\"\n";
		$data .= 'msgstr "' . addslashes($translation->msgstr) . "\"\n";
	    $data .= "\n";
	}
	return file_put_contents($file, $data);
    }
}
