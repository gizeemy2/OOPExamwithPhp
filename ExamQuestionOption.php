<?php

class ExamQuestionOption  //Bu sınıf, bir sorunun seçeneklerini içerir.
{
    protected string $option_id;
    protected ?string $label_html;
    protected ?string $label_text;
    protected string $question_id;

    public function __construct( string $option_id,?string $label_html,?string $label_text,string $question_id) {
        $this->setOptionId($option_id);

        if (empty($label_text) && empty($label_html)) {
            throw new Exception("Hem label_text hem de label_html boş olamaz.");
        }
        $this->setLabelText($label_text) ;
        $this->setLabelHtml($label_html) ;
        $this->setQuestionid($question_id);
    }
    public function validateNodeId($node_id):bool {
        return isset($node_id)
            && is_string($node_id)
            && !!preg_match('/[A-Za-z0-9\_]{8,}/',$node_id);
    }
    public function getQuestionid() {
        return $this->question_id;
    }

    public function setQuestionid(string $question_id) {
        if (!$this->validateNodeId($question_id) ){
            throw new Exception('$question_id geçersiz');
        }
        $this->question_id = $question_id;
    }
    public function getOptionId() {
        return $this->option_id;
    }
    public function setOptionId(string $option_id) {
        if (!$this->validateNodeId($option_id) ){
            throw new Exception('$option_id geçersiz');
        }
        $this->option_id = $option_id;
    }

    public function validatelabel($label):bool{
        if ($label === null  ){
            return true;
        }
        return empty(trim($label));
    }
    public function getLabelText() {
        return $this->label_text;
    }
    public function setLabelText(?string $label_text) {
        if ($this->validatelabel($label_text)) {
            throw new Exception('$label_text dolu olmaldır.');
        }
        $this->label_text = $label_text;
    }

    public function getLabelHtml() {
        return $this->label_html;
    }
    public function setLabelHtml(?string $label_html){
        if ($this->validatelabel($label_html)) {
            throw new Exception('$label_html dolu olmaldır.');
        }
        $this->label_html = $label_html;
    }



}
//$option = new ExamQuestionOption("a5tNGxBe", "", "Hava yolu hastalığı olması", "_nCzThSst");


