<?php

include('./simple_html_dom.php');

class Parser {


	private $item =[];

	function __construct ($url){
		$html = file_get_html($url);
		$i = 0;

			
		foreach ($html->find('article') as $article){

			$id = explode("_", $html->find("li[id^=post]", $i)->id);
			
			$this->item[$i]['title'] = $article->find("h2.post__title", 0)->plaintext;			
			// $item['img'] = $article->find("img", 0)->src;
			$this->item[$i]['text'] = $article->find("div.post__text", 0)->plaintext;
			$this->item[$i]['url'] = $article->find("h2 > a.post__title_link", 0)->href;
			$full_article = file_get_html($this->item[$i]['url']);
			$this->item[$i]['full_text'] = $full_article->find("div.post__text", 0)->innertext;
			$this->item[$i]['article_id'] = $id["1"];

			
			if ($i == "4") {
				break;
			}
			$i = $i + 1;

		}
		
	}

	public function getItem (){
		return $this->item;
	}


}



