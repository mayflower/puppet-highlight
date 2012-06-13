<?php

$html = file_get_contents('http://docs.puppetlabs.com/references/latest/type.html');

$dom = new domDocument();

@$dom->loadHTML($html);
$dom->preserveWhiteSpace = true;

/** @var $types DOMNodeList */
$types = $dom->getElementsByTagName('h3');

$puppetSyntax = array(
    'keywords' => array(
        'class',
        'define',
        'include',
    ),
    'keywords2' => array(),
    'keywords3' => array(),
    'keywords4' => array(
        'present',
        'absent',
        'purged',
        'latest',
        'installed',
        'running',
        'stopped',
        'mounted',
        'unmounted',
        'role',
        'configured',
        'file',
        'directory',
        'link',
        'contained',
        'true',
        'false',
        'undef',
        'alert',
        'crit',
        'debug',
        'emerg',
        'err',
        'fail',
        'include',
        'info',
        'notice',
        'realize',
        'require',
        'search',
        'tag',
        'warning',
        'defined',
        'file',
        'fqdn_rand',
        'generate',
        'inline_template',
        'regsubst',
        'sha1',
        'shellquote',
        'split',
        'sprintf',
        'tagged',
        'template',
        'versioncmp'
    ),

);

$puppetOptions = array(
      "LINE_COMMENT"=> "#",
      "COMMENT_START"=> "/*",
      "COMMENT_END"=> "*/",
      "HEX_PREFIX"=> "",
      "NUM_POSTFIXES"=> "",
      "HAS_BRACKETS"=> "true",
      "HAS_BRACES"=> "true",
      "HAS_PARENS"=> "true",
      "HAS_STRING_ESCAPES"=> "true",
      "LINE_COMMENT_AT_START"=> "false",
);


foreach($types as $type) {
    if(!array_search($type->nodeValue, $puppetSyntax['keywords'])) {
        $puppetSyntax['keywords'][] = $type->nodeValue;
        $puppetSyntax['keywords3'][] = ucfirst($type->nodeValue);
    }
}

/** @var $possibleParameters DOMNodeList */
$possibleParameters = $dom->getElementsByTagName('dl');
foreach($possibleParameters as $parameter) {
    /** @var $parameter DOMNodeList */
    foreach($parameter->getElementsByTagName('dt') as $realParameter) {
        if(!array_search($realParameter->nodeValue, $puppetSyntax['keywords2'])) {
            $puppetSyntax['keywords2'][] = $realParameter->nodeValue;
        }
    }
}

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
$xmlWriter->startDocument('1.0', 'UTF-8');
$xmlWriter->startElement('filetype');
    $xmlWriter->startAttribute('binary');
        $xmlWriter->text('false');
    $xmlWriter->endAttribute();
    $xmlWriter->startAttribute('default_extension');
        $xmlWriter->text('pp');
    $xmlWriter->endAttribute();
    $xmlWriter->startAttribute('description');
        $xmlWriter->text('Puppet manifests');
    $xmlWriter->endAttribute();
    $xmlWriter->startAttribute('name');
        $xmlWriter->text('Puppet manifests');
    $xmlWriter->endAttribute();

    $xmlWriter->startElement('extensionMap'); //<extensionMap>
        $xmlWriter->startElement('mapping'); //<mapping>
        $xmlWriter->startAttribute('ext');
            $xmlWriter->text('pp');
        $xmlWriter->endAttribute();
        $xmlWriter->endElement(); //</mapping>
    $xmlWriter->endElement(); //</extensionMap>

    $xmlWriter->startElement('highlighting'); //<highlighting>

    // binary="false" default_extension="" description="Puppet files" name="Puppet files">
    $xmlWriter->startElement('options');
        foreach($puppetOptions as $key => $value) {
            $xmlWriter->startElement('option'); //<option>
            $xmlWriter->startAttribute('name');
                $xmlWriter->text($key);
            $xmlWriter->endAttribute();
            $xmlWriter->startAttribute('value');
                $xmlWriter->text($value);
            $xmlWriter->endAttribute();
            $xmlWriter->endElement(); //</option>
        }
    $xmlWriter->endElement();

    foreach($puppetSyntax as $key => $value) {
        $xmlWriter->startElement($key); //<keywords1|2|3>
        $xmlWriter->startAttribute('ignore_case');
            $xmlWriter->text('false');
        $xmlWriter->endAttribute();
        foreach($value as $keyword) {
            $xmlWriter->startElement('keyword'); //<keyword>
            $xmlWriter->startAttribute('name');
                $xmlWriter->text($keyword);
            $xmlWriter->endAttribute();
            $xmlWriter->endElement(); //</keyword>
        }
        $xmlWriter->endElement(); //</keywords1|2|3>
    }

    $xmlWriter->endElement(); //</highlighting>
$xmlWriter->endElement(); //</filetype>
$xmlWriter->endDocument();

file_put_contents('Puppet files.xml', $xmlWriter->outputMemory());



