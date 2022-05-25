<?php


namespace Foo;

use Foo\Exception\CharacterAlreadyTriedException;
use Foo\Exception\DoNotCheatException;
use Foo\Exception\GameEndedException;
use Foo\Exception\NotACharacterException;

interface GameInterface
{
    /**
     * Method to test specific letter (case-insensitive)
     *
     *
     * @param string $letter player want to try
     * @return bool true if letter appears in the word
     * @throws CharacterAlreadyTriedException if letter has been already tried
     * @throws GameEndedException if game is already ended
     * @throws NotACharacterException if given parameter is not a latin letter
     */
    public function check(string $letter): bool;

    /**
     * Method to try to guess whole word (case-insensitive)
     *
     * @param string $word
     * @return bool true if word is correct
     */
    public function guessWord(string $word): bool;

    /**
     * Status can be one of three following options: "WIN" | "LOST" | "RUNNING"
     * "WIN" is returned when user guessed all letters in the word or guessed whole word
     * "LOST" if player runs out of tries or tried to guess whole word and it was incorrect
     * "RUNNING" otherwise
     *
     * @return string
     */
    public function status(): string;

    /**
     * @return bool true if games is still in progress (status == "RUNNING")
     */
    public function isRunning(): bool;

    /**
     * @return int how many mistakes player can still make (base should be 7)
     */
    public function mistakesLeft(): int;

    /**
     * current state of game, array with every letter as separate item
     * if letter is still unknown (not yet guessed) it should be changed to underscore "_"
     *
     * e.g. if the word  is foobar and player tried letter "o"
     * state should be returned like this:
     *
     * ["_", "o", "o", "_", "_", "_"]
     *
     * @return array
     */
    public function state(): array;

    /**
     * Method that return word that was in a game. Works only after game was ended
     *
     * @return string word that was guessed
     * @throws DoNotCheatException
     */
    public function word(): string;

    /**
     * Method that allow you to check if player already tried letter
     *
     * @param string $letter
     * @return bool
     * @throws NotACharacterException
     */
    public function alreadyTried(string $letter): bool;

}