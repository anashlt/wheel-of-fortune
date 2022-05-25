<?php


namespace Tests\Foo;

use Foo\Exception\CharacterAlreadyTriedException;
use Foo\Exception\DoNotCheatException;
use Foo\Exception\GameEndedException;
use Foo\Exception\NotACharacterException;
use Foo\Exception\WordCannotBeEmptyException;
use Foo\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function test_game_is_initialized_correctly()
    {
        $game = new Game("exception");
        $this->assertEquals(6, $game->mistakesLeft());
        $this->assertEquals(['_', '_','_', '_', '_', '_', '_', '_', '_'], $game->state());
        $this->assertEquals("RUNNING", $game->status());
    }

    public function test_check_returns_true_when_guess_is_correct()
    {
        $game = new Game("exception");
        $this->assertTrue($game->check("e"));
        $this->assertEquals(['e', '_', '_', 'e', '_','_','_', '_', '_'], $game->state());
    }

    public function test_check_returns_false_when_guess_is_incorrect()
    {
        $game = new Game("exception");
        $this->assertFalse($game->check("a"));
        $this->assertEquals(['_', '_', '_', '_', '_', '_', '_','_','_'], $game->state());
    }

    public function test_exception_is_thrown_when_word_is_empty()
    {
        $this->expectException(WordCannotBeEmptyException::class);
        $game = new Game("");
    }

    public function test_exception_is_thrown_if_character_was_already_tried()
    {
        $game = new Game("exception");
        $game->check("a");
        $this->expectException(CharacterAlreadyTriedException::class);
        $game->check("a");
    }

    public function test_exception_is_thrown_if_game_is_ended_and_player_tries_to_play()
    {
        $game = new Game("exception");
        $game->check("e");
        $game->check("x");
        $game->check("c");
        $game->check("p");
        $game->check("t");
        $game->check("i");
        $game->check("o");
        $game->check("n");
        $this->expectException(GameEndedException::class);
        $game->check("x");
    }

    public function test_exception_is_thrown_if_game_is_ended_by_guess_and_player_tries_to_play()
    {
        $game = new Game("exception");
        $game->guessWord("exception");
        $this->expectException(GameEndedException::class);
        $game->guessWord("exception");
    }

    public function test_exception_is_thrown_if_character_is_digit()
    {
        $game = new Game("exception");
        $this->expectException(NotACharacterException::class);
        $game->check("0");
    }

    public function test_exception_is_thrown_if_character_is_longer_than_one_character()
    {
        $game = new Game("exception");
        $this->expectException(NotACharacterException::class);
        $game->check("xx");
    }

    public function test_if_character_is_uppercase()
    {
        $game = new Game("exception");
        $this->assertTrue($game->check("O"));
    }

    public function test_exception_is_thrown_if_character_is_uppercase_and_tried_again()
    {
        $game = new Game("exception");
        $game->check("o");
        $this->expectException(CharacterAlreadyTriedException::class);
        $game->check("O");
    }

    public function test_number_of_mistakes_decrease_with_incorrect_guess()
    {
        $game = new Game("exception");
        $game->check("a");
        $this->assertEquals(5, $game->mistakesLeft());
    }

    public function test_number_of_tries_stays_with_correct_guess()
    {
        $game = new Game("exception");
        $game->check("o");
        $this->assertEquals(6, $game->mistakesLeft());
    }

    public function test_status_LOST_is_set_when_all_tries_are_used()
    {
        $game = new Game("exception");
        $game->check("a");
        $game->check("b");
        $game->check("d");
        $game->check("f");
        $game->check("g");
        $game->check("u");
        $this->assertEquals(0, $game->mistakesLeft());
        $this->assertEquals("RUNNING", $game->status());
        $game->check("r");
        $this->assertEquals("LOST", $game->status());
        $this->assertEquals(0, $game->mistakesLeft());
    }

    public function test_you_cannot_guess_anymore_after_7_tries()
    {
        $game = new Game("exception");
        $game->check("a");
        $game->check("b");
        $game->check("d");
        $game->check("f");
        $game->check("g");
        $game->check("u");
        $game->check("r");
        $this->expectException(GameEndedException::class);
        $game->check("h");

    }

    public function test_status_WIN_is_set_when_all_letters_are_used()
    {
        $game = new Game("exception");
        fwrite(STDERR, print_r($game->state(), TRUE));
        $game->check("e");
        $game->check("x");
        $game->check("c");
        $game->check("p");
        $game->check("t");
        $game->check("i");
        $game->check("o");
        $game->check("n");
        $this->assertEquals("WIN", $game->status());
    }

    public function test_status_LOST_is_set_when_wrong_word_was_guessed()
    {
        $game = new Game("exception");
        $this->assertFalse($game->guessWord("foo"));
        $this->assertEquals("LOST", $game->status());
    }

    public function test_status_WIN_is_set_when_correct_word_was_guessed()
    {
        $game = new Game("exception");
        $this->assertTrue($game->guessWord("exception"));
        $this->assertEquals("WIN", $game->status());
    }

    public function test_word_throws_exception_when_used_in_game()
    {
        $game = new Game("exception");
        $this->expectException(DoNotCheatException::class);
        $game->word();
    }

    public function test_word_return_word_after_guess()
    {
        $game = new Game("exception");
        $game->guessWord("exception");
        $this->assertEquals("exception", $game->word());
    }

    public function test_already_tried_check()
    {
        $game = new Game("exception");
        $this->assertFalse($game->alreadyTried("a"));
        $this->assertFalse($game->alreadyTried("b"));
        $this->assertFalse($game->alreadyTried("A"));
        $this->assertFalse($game->alreadyTried("B"));
        $game->check("a");
        $this->assertTrue($game->alreadyTried("a"));
        $this->assertFalse($game->alreadyTried("b"));
        $this->assertTrue($game->alreadyTried("A"));
        $this->assertFalse($game->alreadyTried("B"));
    }
}