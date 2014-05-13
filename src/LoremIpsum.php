<?php

namespace joshtronic;

class LoremIpsum
{
	private $first             = true;
	private $sentence_mean     = 24.46;
	private $sentence_std_dev  = 5.08;
	private $paragraph_mean    = 5.8;
	private $paragraph_std_dev = 1.93;

	public $words = array(
		// Lorem ipsum...
		'lorem',        'ipsum',       'dolor',        'sit',
		'amet',         'consectetur', 'adipiscing',   'elit',
		// The rest of the vocabulary
		'a',            'ac',          'accumsan',     'ad',
		'aenean',       'aliquam',     'aliquet',      'ante',
		'aptent',       'arcu',        'at',           'auctor',
		'augue',        'bibendum',    'blandit',      'class',
		'commodo',      'condimentum', 'congue',       'consequat',
		'conubia',      'convallis',   'cras',         'cubilia',
		'cum',          'curabitur',   'curae',        'cursus',
		'dapibus',      'diam',        'dictum',       'dictumst',
		'dignissim',    'dis',         'donec',        'dui',
		'duis',         'egestas',     'eget',         'eleifend',
		'elementum',    'enim',        'erat',         'eros',
		'est',          'et',          'etiam',        'eu',
		'euismod',      'facilisi',    'facilisis',    'fames',
		'faucibus',     'felis',       'fermentum',    'feugiat',
		'fringilla',    'fusce',       'gravida',      'habitant',
		'habitasse',    'hac',         'hendrerit',    'himenaeos',
		'iaculis',      'id',          'imperdiet',    'in',
		'inceptos',     'integer',     'interdum',     'justo',
		'lacinia',      'lacus',       'laoreet',      'lectus',
		'leo',          'libero',      'ligula',       'litora',
		'lobortis',     'luctus',      'maecenas',     'magna',
		'magnis',       'malesuada',   'massa',        'mattis',
		'mauris',       'metus',       'mi',           'molestie',
		'mollis',       'montes',      'morbi',        'mus',
		'nam',          'nascetur',    'natoque',      'nec',
		'neque',        'netus',       'nibh',         'nisi',
		'nisl',         'non',         'nostra',       'nulla',
		'nullam',       'nunc',        'odio',         'orci',
		'ornare',       'parturient',  'pellentesque', 'penatibus',
		'per',          'pharetra',    'phasellus',    'placerat',
		'platea',       'porta',       'porttitor',    'posuere',
		'potenti',      'praesent',    'pretium',      'primis',
		'proin',        'pulvinar',    'purus',        'quam',
		'quis',         'quisque',     'rhoncus',      'ridiculus',
		'risus',        'rutrum',      'sagittis',     'sapien',
		'scelerisque',  'sed',         'sem',          'semper',
		'senectus',     'sociis',      'sociosqu',     'sodales',
		'sollicitudin', 'suscipit',    'suspendisse',  'taciti',
		'tellus',       'tempor',      'tempus',       'tincidunt',
		'torquent',     'tortor',      'tristique',    'turpis',
		'ullamcorper',  'ultrices',    'ultricies',    'urna',
		'ut',           'varius',      'vehicula',     'vel',
		'velit',        'venenatis',   'vestibulum',   'vitae',
		'vivamus',      'viverra',     'volutpat',     'vulputate',
	);

	public function word($tags = false)
	{
		return $this->words(1, $tags);
	}

	public function wordsArray($count = 1, $tags = false)
	{
		return $this->words($count, $tags, true);
	}

	// TODO Need to refactor to allow for counts larger than array of words
	public function words($count = 1, $tags = false, $array = false)
	{
		$this->shuffle();

		$words = array_slice($this->words, 0, $count);

		return $this->output($words, $tags, $array);
	}

	public function sentence($tags = false)
	{
		return $this->sentences(1, $tags);
	}

	public function sentencesArray($count = 1, $tags = false)
	{
		return $this->sentences($count, $tags, true);
	}

	public function sentences($count = 1, $tags = false, $array = false)
	{
		$sentences = array();

		for ($i = 0; $i < $count; $i++)
		{
			$sentences[] = $this->wordsArray($this->gauss($this->sentence_mean, $this->sentence_std_dev));
		}

		$this->punctuate($sentences);

		return $this->output($sentences, $tags, $array);
	}

	public function paragraph($tags = false)
	{
		return $this->paragraphs(1, $tags);
	}

	public function paragraphsArray($count = 1, $tags = false)
	{
		return $this->paragraphs($count, $tags, true);
	}

	public function paragraphs($count = 1, $tags = false, $array = false)
	{

	}

	private function gauss($mean, $std_dev)
	{
		$x = mt_rand() / mt_getrandmax();
		$y = mt_rand() / mt_getrandmax();
		$z = sqrt(-2 * log($x)) * cos(2 * pi() * $y);

		return $z * $std_dev + $mean;
	}

	private function shuffle()
	{
		if ($this->first)
		{
			$this->first = array_slice($this->words, 0, 8);
			$this->words = array_slice($this->words, 8);

			shuffle($this->words);

			$this->words = $this->first + $this->words;

			$this->first = false;
		}
		else
		{
			shuffle($this->words);
		}
	}

	private function punctuate(&$sentences)
	{
		foreach ($sentences as $key => $sentence)
		{
			$words = count($sentence);

			if ($words > 4)
			{
				$mean    = log($words, 6);
				$std_dev = $mean / 6;
				$commas  = round($this->gauss($mean, $std_dev));

				for ($i = 1; $i <= $commas; $i++)
				{
					$word = round($i * $words / ($commas + 1));

					if ($word < ($words - 1) && $word > 0)
					{
						$sentence[$word] .= ',';
					}
				}

				$sentences[$key] = ucfirst(implode(' ', $sentence) . '.');
			}
		}
	}

	private function output($strings, $tags, $array)
	{
		if ($tags)
		{
			if (!is_array($tags))
			{
				$tags = array($tags);
			}
			else
			{
				$tags = array_reverse($tags);
			}

			foreach ($strings as $key => $string)
			{
				foreach ($tags as $tag)
				{
					if ($tag[0] == '<')
					{
						$string = str_replace('$1', $string, $tag);
					}
					else
					{
						$string = sprintf('<%1$s>%2$s</%1$s>', $tag, $string);
					}

					$strings[$key] = $string;
				}
			}
		}

		if (!$array)
		{
			$strings = implode(' ', $strings);
		}

		return $strings;
	}
}

?>
