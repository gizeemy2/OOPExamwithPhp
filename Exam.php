<?php

class Exam{
    protected array $questions = [] ;

    function __construct(array $questions)
    {
        $this->questions($questions);
    }

    //aynı getOptionId bir sınav sorusunun zaten var olup olmadığını kontrol eder.

    // Bu kontrol, bir dizide belirli bir anahtar varsa doğru döndüren array_key_exists işlevi kullanılarak yapılır.
    //Aynı getOptionId sahip bir soru zaten varsa, fonk soruyu eklemeden geri döner.


    public function addQuestion(ExamQuestion $question) {  // Sınava soru eklemek için
        if (array_key_exists($question->getQuestionId(), $this->questions)) {
            return;
        }
        $this->questions[$question->getQuestionId()] = $question;
    }

    // Eğer $question_id string türünde değilse, null değerini döndürür.
    // Aksi durumda, $this->questions[$question_id] değeri tanımlı ise bu değeri, değilse null değerini döndürür.
    public function getQuestionById($question_id) {     //sorulara ID'ye göre erişmek için
        if (!is_string($question_id)) {
            return null;
        }
        return isset($this->questions[$question_id]) ? $this->questions[$question_id] : null;
    }


    public function getQuestionCount() { //Exam clasının $questions dizisinde saklanan toplam soru sayısını döndürmek için
        return count($this->questions);
    }


    //$this->questions dizisi içindeki tüm sorular kontrol edilir ve eğer soru "isAnsweredCorrectly" fonksiyonu ile doğru cevaplandıysa $correctAnswers değişkeni bir arttırılır.
    // Son olarak $correctAnswers değişkeni döndürülür.
    public function getCorrectAswersCount() { //doğru cevapların sayısını almak için
        $correctAnswers = 0;
        foreach ($this->questions as $question) {
            if ($question->isAnsweredCorrectly()) {
                $correctAnswers++;
            }
        }
        return $correctAnswers;
    }

    public function calculateResult() { //sonuçları hesaplamak için
        return $this->getCorrectAswersCount() / $this->getQuestionCount();
    }

    // $this->questions dizisi içindeki tüm sorular kontrol edilir
    // eğer soru doğru cevaplandıysa o sorunun "getPointValue" fonksiyonu ile belirlenen puanı $pointsCorrectAnswer'a eklenir.
    //Aynı şekilde her sorunun puanı $pointsTotal değişkenine eklenir.
    public function calculateResultPoints() { //sorulara verilen puanların ortalamasını hesaplamak için
        $pointsCorrectAnswer = 0;
        $pointsTotal = 0;
        foreach ($this->questions as $question) {
            $pointsTotal += $question->getPointValue();
            if ($question->isAnsweredCorrectly() ) {
                $pointsCorrectAnswer += $question->getPointValue();
            }
        }
        return $pointsCorrectAnswer / $pointsTotal;
    }

    public function getQuestionList() { //soruların listesini almak için
        return array_values($this->questions);
    }


    public function toJson() {  //sınavın JSON formatında verilerini almak için toJson()
        $questions = [];
        foreach ($this->questions as $question) {
            $questions[] = [
                'id' => $question->id,
                'label_html' => $question->label_html,
                'label_text' => $question->label_text,
                'options' => $question->options,
            ];
        }
        return json_encode([
            'questions' => $questions,
        ]);
    }


}

