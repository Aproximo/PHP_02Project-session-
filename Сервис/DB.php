<?php


class DB {

	private $user = 'root';

	private $pass = '';

	private $PDO;

	function __construct () {

		$this->PDO= new PDO ('mysql:host=localhost;dbname=testphp;charset=utf8', $this->user, $this->pass);
		
	}

	public function Insert ($array, $id) {
		 $sql = 'iNSERT INTO article (article_id, title, text, full_text, catid)
		 values (:article_id, :title, :text, :full_text, :catid)';

    $stmt = $this->PDO->prepare($sql);

    $stmt->execute(array(':article_id'=>$array['article_id'], ':title' => $array['title'], ':text' => $array['text'], ':full_text' => $array['full_text'], ':catid' => $id));

    return $stmt->fetch();
	}

	public function Select ($id){

		 $sql = 'Select * from article where article_id = :article_id';

    $stmt = $this->PDO->prepare($sql);

    $stmt->execute(array(':article_id'=>$id));

    return $stmt->fetch();

	}

	public function update ($array){

		$sql = 'update article set title = :title, text = :text, full_text = :full_text where article_id=:article_id';

    $stmt = $this->PDO->prepare($sql);

    $stmt->execute(array(':title' => $array['title'], ':text' => $array['text'], ':full_text' => $array['full_text'], ':article_id'=>$array['article_id']));

    $row = $stmt->fetch();

	}
	
}

