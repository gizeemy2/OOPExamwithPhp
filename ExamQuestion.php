<?php

class ExamQuestion
{
    protected string $question_id;
    protected ?string $label_text = null;
    protected ?string $label_html = null;
    protected string $answer_id;
    protected ?string $userSelectedOptionId = null ;
    protected array $options = [] ;
    protected int $pointValue;


    public function __construct(string $question_id, ?string $label_text, ?string $label_html, string $answer_id, ?string $userSelectedOptionId, ?array $options, int $pointValue) {
        $this->setQuestionId($question_id);

        if (empty($label_text) && empty($label_html)) {
            throw new Exception("Hem label_text hem de label_html boş olamaz.");
        }
        $this->setLabelText($label_text) ;
        $this->setLabelHtml($label_html) ;
        $this->setAnswerId($answer_id) ;
        $this->setuserSelectedOptionId($userSelectedOptionId) ;
        $this->setOptions($options);
        $this->setPointValue($pointValue);


    }

    public function getAnswerId() {
        return $this->answer_id;
    }

    public function setAnswerId(string $answer_id){
        if (!$this->validateNodeId($answer_id)){
            throw new Exception('$answer_id geçersiz');
        }
        $this->answer_id=$answer_id;
    }
    public function getQuestionId() {
        return $this->question_id;
    }
    public function setQuestionId(string $question_id){
        if (!$this->validateNodeId($question_id) ){
            throw new Exception('$question_id geçersiz');
        }
        $this->question_id = $question_id;
    }
    public function getuserSelectedOptionId(){
        return $this->userSelectedOptionId;
    }
    public function setuserSelectedOptionId(?string $userSelectedOptionId){
        if (!$this->validateNodeId($userSelectedOptionId)){
            throw new Exception('$userSelectedOptionId geçersiz');
        }
        $this->userSelectedOptionId=$userSelectedOptionId;
    }
    public function validateNodeId($node_id):bool {
        return isset($node_id)
            && is_string($node_id)
            && !!preg_match('/[A-Za-z0-9\_]{8,}/',$node_id);
    }
    public function validatelabel($label):bool{
        if ($label === null  ){
            return true;
        }
        return empty(trim($label));
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
    public function getLabelText() {
        return $this->label_text;
    }

    public function setLabelText(?string $label_text) {
        if ($this->validatelabel($label_text)) {
            throw new Exception('$label_text dolu olmaldır.');
        }
        $this->label_text = $label_text;
    }
    public function getOptions(): array {
        return $this->options;
    }

    public function setOptions(array $options) {
        $this->options = $options;
    }
    public function getOptionList() { //sorunun tüm seçeneklerini dizi olarak döndürür
        return array_values($this->options);
    }



    //ExamQuestionOption clasından bir nesne alır ve bu nesnenin optionId'sine göre options dizisi içinde  kaydedilir.
    public function addOption(ExamQuestionOption $option) {

        if (array_key_exists($option->getOptionId(), $this->options)) {
            return;
        }
        $this->options[$option->getOptionId()] = $option;
    }

    //belirtilen option_Id'ye göre options dizisinde bir anahtar arar ve bu anahtarın değerini döndürür. Eğer anahtar bulunamazsa null döndürür.
    public function getOptionById($option_id) {
        return array_key_exists($option_id, $this->options) ? $this->options[$option_id] : null;
    }


    public function setCorrectAnswerId($option_id) {      // doğru cevabı belirleme
        if (array_key_exists($option_id, $this->options)) {
            $this->answer_id = $option_id;
            return true;
        }
        $this->answer_id = null;
        return false;
    }

    //Sorunun doğru yanıtlanıp yanıtlanmadığını gösterir.
    //Hem userSelectedOptionId hem de answer_id öğesinin boş ve birbirine eşit olup olmadığını kontrol eder.
    public function isAnsweredCorrectly() {
        return $this->userSelectedOptionId !== null &&
            $this->answer_id !== null &&
            $this->userSelectedOptionId === $this->answer_id;
    }

    //sınav sorunun puan değerini döndürür. Eğer puan değeri tanımlanmamış veya 0 veya negatif bir değere sahipse, 1 değerini döndürür.
    public function getPointValue() {
        return $this->pointValue > 0 ? $this->pointValue : 1;
    }


    // sınav sorunun puan değerini belirler. Eğer verilen değer tanımlanmamış veya 0 veya negatif bir değere sahipse, 1 değerini atar.
    public function setPointValue($pointValue) {
        if (!$pointValue || !is_int($pointValue) || ($pointValue < 0)) {
            $pointValue = 1;
        }
        $this->pointValue = $pointValue;
    }




}