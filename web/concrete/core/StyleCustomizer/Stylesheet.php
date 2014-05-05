<?php
namespace Concrete\Core\StyleCustomizer;
class Stylesheet {

    protected $file; // full path to stylesheet e.g. /full/path/to/concrete/themes/greek_yogurt/css/main.less
    protected $sourceUriRoot; // root of source. e.g. /concrete/themes/greek_yogurt/
    protected $outputDirectory; // e.g /full/path/to/files/cache/themes/greek_yogurt/css/main.css"
    protected $relativeOutputDirectory; // e.g /files/cache/themes/greek_yogurt/css/main.css"
    protected $stylesheet; // e.g "css/main.less";

    protected $valueList;

    public function __construct($stylesheet, $file, $sourceUriRoot, $outputDirectory, $relativeOutputDirectory) {
        $this->stylesheet = $stylesheet;
        $this->file = $file;
        $this->sourceUriRoot = $sourceUriRoot;
        $this->outputDirectory = $outputDirectory;
        $this->relativeOutputDirectory = $relativeOutputDirectory;
    }

    public function setValueList(\Concrete\Core\StyleCustomizer\Style\ValueList $valueList) {
        $this->valueList = $valueList;
    }
    /**
     * Compiles the stylesheet using LESS. If a ValueList is provided they are
     * injected into the stylesheet
     * @return string CSS
     */
    public function getCss($valueList = false) {
        $parser = new \Less_Parser(array('compress' => false));
        $parser = $parser->parseFile($this->file, $this->sourceUriRoot);
        if (isset($this->valueList) && $this->valueList instanceof \Concrete\Core\StyleCustomizer\Style\ValueList) {
            $variables = array();
            foreach($this->valueList->getValues() as $value) {
                $variables = array_merge($value->toLessVariablesArray(), $variables);
            }
            $parser->ModifyVars($variables);
        }
        $css = $parser->getCss();
        return $css;
    }

    public function output() {
        $css = $this->getCss();
        $path = dirname($this->getOutputPath());
        if (!file_exists($path)) {
            @mkdir($path, DIRECTORY_PERMISSIONS_MODE, true);
        }
        file_put_contents($this->getOutputPath(), $css);
    }

    public function clearOutputFile() {
        @unlink($this->getOutputPath());
    }

    public function outputFileExists() {
        return file_exists($this->getOutputPath());
    }

    public function getOutputPath() {
        return $this->outputDirectory . '/' . str_replace('.less', '.css', $this->stylesheet);
    }

    public function getOutputRelativePath() {
        return $this->relativeOutputDirectory . '/' . str_replace('.less', '.css', $this->stylesheet);
    }

}