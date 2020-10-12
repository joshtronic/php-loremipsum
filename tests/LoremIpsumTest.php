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
    /**
     * @doesNotPerformAssertions
     */
    public function testAssertRegExp() {
        if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
            return 'assertMatchesRegularExpression';
        }

        return 'assertRegExp';
    }

    /**
     * @depends testAssertRegExp
     */
    public function testWord($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp('/^[a-z]+$/i', $lipsum->word());
    }

    /**
     * @depends testAssertRegExp
     */
    public function testWords($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^[a-z]+ [a-z]+ [a-z]+$/i',
            $lipsum->words(3)
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testWordsArray($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $words = $lipsum->wordsArray(3);
        $this->assertTrue(is_array($words));
        $this->assertCount(3, $words);

        foreach ($words as $word) {
            $this->$assertRegExp('/^[a-z]+$/i', $word);
        }
    }

    /**
     * @depends testAssertRegExp
     */
    public function testWordsExceedingVocab($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->assertCount(500, $lipsum->wordsArray(500));
    }

    /**
     * @depends testAssertRegExp
     */
    public function testSentence($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp('/^[a-z, ]+\.$/i', $lipsum->sentence());
    }

    /**
     * @depends testAssertRegExp
     */
    public function testSentences($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^[a-z, ]+\. [a-z, ]+\. [a-z, ]+\.$/i',
            $lipsum->sentences(3)
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testSentencesArray($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $sentences = $lipsum->sentencesArray(3);
        $this->assertTrue(is_array($sentences));
        $this->assertCount(3, $sentences);

        foreach ($sentences as $sentence) {
            $this->$assertRegExp('/^[a-z, ]+\.$/i', $sentence);
        }
    }

    /**
     * @depends testAssertRegExp
     */
    public function testParagraph($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp('/^([a-z, ]+\.)+$/i', $lipsum->paragraph());
    }

    /**
     * @depends testAssertRegExp
     */
    public function testParagraphs($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^([a-z, ]+\.)+\n\n([a-z, ]+\.)+\n\n([a-z, ]+\.)+$/i',
            $lipsum->paragraphs(3)
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testParagraphsArray($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $paragraphs = $lipsum->paragraphsArray(3);
        $this->assertTrue(is_array($paragraphs));
        $this->assertCount(3, $paragraphs);

        foreach ($paragraphs as $paragraph) {
            $this->$assertRegExp('/^([a-z, ]+\.)+$/i', $paragraph);
        }
    }

    /**
     * @depends testAssertRegExp
     */
    public function testMarkupString($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^<li>[a-z]+<\/li>$/i',
            $lipsum->word('li')
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testMarkupArray($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^<div><p>[a-z]+<\/p><\/div>$/i',
            $lipsum->word(array('div', 'p'))
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testMarkupBackReference($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $this->$assertRegExp(
            '/^<li><a href="[a-z]+">[a-z]+<\/a><\/li>$/i',
            $lipsum->word('<li><a href="$1">$1</a></li>')
        );
    }

    /**
     * @depends testAssertRegExp
     */
    public function testMarkupArrayReturn($assertRegExp)
    {
        $lipsum = new joshtronic\LoremIpsum();
        $words = $lipsum->wordsArray(3, 'li');
        $this->assertTrue(is_array($words));
        $this->assertCount(3, $words);

        foreach ($words as $word) {
            $this->$assertRegExp('/^<li>[a-z]+<\/li>$/i', $word);
        }
    }
}

