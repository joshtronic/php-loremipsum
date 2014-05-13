<?php

require_once '../src/LoremIpsum.php';

class LoremIpsumTest extends PHPUnit_Framework_TestCase
{
	private $lipsum;

	public function setUp()
	{
		$this->lipsum = new joshtronic\LoremIpsum();
	}

	public function testWord()
	{
		$this->assertRegExp('/^[a-z]+$/i', $this->lipsum->word());
	}

	public function testWords()
	{
		$this->assertRegExp(
			'/^[a-z]+ [a-z]+ [a-z]+$/i',
			$this->lipsum->words(3)
		);
	}

	public function testWordsArray()
	{
		$words = $this->lipsum->wordsArray(3);
		$this->assertTrue(is_array($words));
		$this->assertCount(3, $words);

		foreach ($words as $word)
		{
			$this->assertRegExp('/^[a-z]+$/i', $word);
		}
	}

	/*
	public function testSentence()
	{
		$this->assertRegExp('/^[a-z, ]+\.$/i', $this->lipsum->sentence());
	}

	public function testSentences()
	{
		$this->assertRegExp('/^[a-z, ]+\. [a-z, ]+\. [a-z, ]+\.$/i', $this->lipsum->sentences(3));
	}

	public function testSentencesArray()
	{
		$sentences = $this->lipsum->sentencesArray(3);
		$this->assertTrue(is_array($sentences));
		$this->assertCount(3, $sentences);

		foreach ($words as $word)
		{
			$this->assertRegExp('/^[a-z, ]+\.$/i', $sentence);
		}
	}

	public function testParagraph()
	{

		$this->fail('Not yet implemented.');
	}

	public function testParagraphs()
	{

		$this->fail('Not yet implemented.');
	}

	public function testParagraphsArray()
	{

		$this->fail('Not yet implemented.');
	}
	*/

	public function testMarkupString()
	{
		$this->assertRegExp(
			'/^<li>[a-z]+<\/li>$/i',
			$this->lipsum->word('li')
		);
	}

	public function testMarkupArray()
	{
		$this->assertRegExp(
			'/^<div><p>[a-z]+<\/p><\/div>$/i',
			$this->lipsum->word(array('div', 'p'))
		);
	}

	public function testMarkupBackReference()
	{
		$this->assertRegExp(
			'/^<li><a href="[a-z]+">[a-z]+<\/a><\/li>$/i',
			$this->lipsum->word('<li><a href="$1">$1</a></li>')
		);
	}

	/*
	public function testMarkupArrayReturn()
	{
		$words = $this->lipsum->wordsArray(3, 'li');
		$this->assertTrue(is_array($words));
		$this->assertCount(3, $words);

		foreach ($words as $word)
		{
			$this->assertRegExp('/^<li>[a-z]+<\/li>$/i', $word);
		}
	}
	*/
}

?>
