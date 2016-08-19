# Ledcoin

Táto aplikácia slúži ako pomôcka pri manažovaní táborovej meny ledcoin na [Letnom sústredení talentovanej mládeže v elektronike](http://www.lstme.sk).

# Požiadavky

- PHP 5.6
- MySql 5.6
- composer

# Inštalácia

1. naklonujte repozitár na server, nastavte virtualhost
2. v koreňovom adresáry aplikácie spustite príkaz `init` a v jednotlivých krokoch potom:
	1. vyberte prostredie aplikácie
	2. nakonfigurujte pripojenie na databázu
	3. spustite migrácie a vytvorte databázovú schému
	4. vytvorte prvý účet používateľa (administrátora)

_Pozn: pred inštaláciou je treba pripraviť si prázdnu databázu._
