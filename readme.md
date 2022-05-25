Zadanie polega na napisaniu obiektowej implementacji uproszczonej wersji popularnej gry "Koło fortuny".Gra polega na próbie odgadnięcia zakrytego słowa poprzez próby zgadywania poszczególnych liter.

Zasady gry:
- gracz wybiera literę; jeśli litera ta znajduje się w słowie wszystkie pozycje tej litery zostają "odsłonięte"; jeśli litery nie ma w słowie, zapisywana jest jako błąd;
- gracz ma możliwość popełnienia 6 błędów (sześć razy trafić literę której nie ma w słowie; 7-te błędne trafienie spowoduje zakończenie gry)
- gracz wygrywa jeśli wszystkie litery ze słowa zostaną odgadnięte
- gracz ma możliwość odgadnięcia całego słowa od razu, które kończy grę; jeśli słowo jest poprawne - gracz wygrywa
- każdą literę można sprobówać tylko raz

Dodatkowe zasady w implementacji:
- wielkość liter nie ma znaczenia w implementacji (klasa musi działać poprawnie niezależnie od wielkości podawanych liter )
- bierzemy pod uwagę tylko litery alfabetu łacińskiego

Zadanie:
Zadanie polega na uzupełnieniu klasy Game zgodnie z powyższymi zasadami gry. Klasa powinna implementować interfejs GameInterface.
W klasie Game i w GameInterface znajdziesz podpowiedzi jakie funkcjonalności/warunki powinny znaleźć się w każdej z metod. 
Sama implementacja zależy od Ciebie. Możesz dodawać metody prywatne / inne klasy - wymogiem jest jedynie spełnienie interfejsu.

W zestawie znajdziesz również zestaw testów phpunit, które pomogą Ci potwierdzić poprawność Twojej implementacji ( uruchamiane po instalacji za pomocą composera za pomocą komendy: php vendor/bin/phpunit )

Do wykonania zadania potrzebujesz jedynie instancji PHP w wersji wyższej bądź równej 7.2 oraz Composera (​ https://getcomposer.org/​ )

Uwagi:
- Twój kod nie powinien nic wyświetlać! (tylko poprawnie, tj. zgodnie z opisem powyżej, zwracać
odpowiednie wartości).
- Twój kod nie powinien zapisywać nic do bazy danych, ani innych miejsc - zapis stanu gry nie jest częścią
zadania

Oceniane będą:
- zgodność z wymaganiami / specyfikacją
- poprawność implementacji
- programowanie obiektowe
- czytelność kodu

POWODZENIA!
