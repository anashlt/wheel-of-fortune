<?php
declare(strict_types=1);

namespace Foo;

use Foo\Exception\CharacterAlreadyTriedException;
use Foo\Exception\DoNotCheatException;
use Foo\Exception\GameEndedException;
use Foo\Exception\NotACharacterException;
use Foo\Exception\WordCannotBeEmptyException;

final class Game implements GameInterface
{
    private string $word;
    public string $status;
    public int $wrongGuess;
    private const MAX_WRONG_GUESS = 6;
    private array $state;
    public array $choices;

    /**
     * @param string $word word that player needs to guess
     *
     * @throws WordCannotBeEmptyException if given word is empty
     */
    public function __construct(string $word)
    {
        // If word is empty throw an exception
        if(empty($word)) 
        {
            throw new WordCannotBeEmptyException('Word cannot be empty!');
        }

        // Initializing
        $this->word = strtolower($word);
        $this->status = 'RUNNING';
        $this->wrongGuess = 0;
        $this->choices = [];
        $this->state = array_fill(0, strlen($word), '_'); // placeholder according to len of the word
    }

    /**
     * @inheritDoc
     */
    public function check(string $letter): bool
    {
        // Check game status before attempting
        if(!$this->isRunning())
        {
            throw new GameEndedException('Game ended already');
        }

        // Check given character is a single valid alphabet
        if(strlen($letter) > 1 || !ctype_alpha($letter)) {
            throw new NotACharacterException('Not a valid character');
        }        

        // Check if we still have a chance
        if($this->mistakesLeft() > 0)
        {

            // Verify wether the letter was chosen already
            if($this->alreadyTried($letter))
            {
                throw new CharacterAlreadyTriedException('Already tried');
            }
            // if not store it in the choices arr
            array_push($this->choices, $letter); 

            // check if letter is part of the word
            if(str_contains($this->word, strtolower($letter))) {
                // place it in the state array with the appropriate idx
                foreach(str_split($this->word) as $key=>$char) 
                {
                    if($char == $letter) 
                    {
                        $this->state[$key] = $letter;
                    }
                } 
                // verify whether the word was fully discovered (WIN)
                if (str_split($this->word) === $this->state) 
                {
                    $this->status = 'WIN';
                }
                return true;
            } // letter isnt part of the word
            else 
            {
                $this->wrongGuess++;
                return false;
            }
        } // no chances left (LOST)
        else 
        {
            $this->status = 'LOST';
        }
        return false;
    }

    /**
     * @inheritDoc
     * @throws GameEndedException
     */
    public function guessWord(string $word): bool
    {
        if(!$this->isRunning())
        {
            throw new GameEndedException('Game ended already');
        }

        if(strtolower($word) == $this->word)
        {
            $this->status = 'WIN';
            return true;
        }

        $this->status = 'LOST';
        return false;
    }

    /**
     * @inheritDoc
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function isRunning(): bool
    {
        if($this->status() == 'RUNNING') {
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function mistakesLeft(): int
    {
        return self::MAX_WRONG_GUESS - $this->wrongGuess;
    }

    /**
     * @inheritDoc
     */
    public function state(): array
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function word(): string
    {
        if($this->status() == 'RUNNING')
        {
            throw new DoNotCheatException('No cheating...');
        }
        return $this->word;
    }

    /**
     * @inheritDoc
     */
    public function alreadyTried(string $letter): bool
    {
        if (in_array(strtolower($letter), $this->choices))
        {
            return true;
        }
        return false;
    }

}