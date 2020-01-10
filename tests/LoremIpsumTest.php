<?php
require_once './src/LoremIpsum.php';

if (
    !class_exists('\PHPUnit_Framework_TestCase')
    && class_exists('\PHPUnit\Framework\TestCase')
) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}

class LoremIpsumTest extends PHPUnit_Framework_TestCase
{
    public function testWord()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp('/^[a-z]+$/i', $lipsum->word());
    }

    public function testWords()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^[a-z]+ [a-z]+ [a-z]+$/i',
            $lipsum->words(3)
        );
    }

    public function testWordsArray()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $words = $lipsum->wordsArray(3);
        $this->assertTrue(is_array($words));
        $this->assertCount(3, $words);

        foreach ($words as $word) {
            $this->assertRegExp('/^[a-z]+$/i', $word);
        }
    }

    public function testWordsExceedingVocab()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertCount(500, $lipsum->wordsArray(500));
    }

    public function testSentence()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp('/^[a-z, ]+\.$/i', $lipsum->sentence());
    }

    public function testSentences()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^[a-z, ]+\. [a-z, ]+\. [a-z, ]+\.$/i',
            $lipsum->sentences(3)
        );
    }

    public function testSentencesArray()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $sentences = $lipsum->sentencesArray(3);
        $this->assertTrue(is_array($sentences));
        $this->assertCount(3, $sentences);

        foreach ($sentences as $sentence) {
            $this->assertRegExp('/^[a-z, ]+\.$/i', $sentence);
        }
    }

    public function testParagraph()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp('/^([a-z, ]+\.)+$/i', $lipsum->paragraph());
    }

    public function testParagraphs()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^([a-z, ]+\.)+\n\n([a-z, ]+\.)+\n\n([a-z, ]+\.)+$/i',
            $lipsum->paragraphs(3)
        );
    }

    public function testParagraphsArray()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $paragraphs = $lipsum->paragraphsArray(3);
        $this->assertTrue(is_array($paragraphs));
        $this->assertCount(3, $paragraphs);

        foreach ($paragraphs as $paragraph) {
            $this->assertRegExp('/^([a-z, ]+\.)+$/i', $paragraph);
        }
    }

    public function testMarkupString()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^<li>[a-z]+<\/li>$/i',
            $lipsum->word('li')
        );
    }

    public function testMarkupArray()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^<div><p>[a-z]+<\/p><\/div>$/i',
            $lipsum->word(array('div', 'p'))
        );
    }

    public function testMarkupBackReference()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertRegExp(
            '/^<li><a href="[a-z]+">[a-z]+<\/a><\/li>$/i',
            $lipsum->word('<li><a href="$1">$1</a></li>')
        );
    }

    public function testMarkupArrayReturn()
    {
        $lipsum = new joshtronic\LoremIpsum();
        $words = $lipsum->wordsArray(3, 'li');
        $this->assertTrue(is_array($words));
        $this->assertCount(3, $words);

        foreach ($words as $word) {
            $this->assertRegExp('/^<li>[a-z]+<\/li>$/i', $word);
        }
    }
}

