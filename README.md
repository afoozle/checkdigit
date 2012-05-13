Check Digit [![Build Status](https://secure.travis-ci.org/afoozle/checkdigit.png)](http://travis-ci.org/afoozle/checkdigit)
===========

This library is built to handle validating checkdigits in a variety of formats.

Installing
==========
TODO


Testing
=======
Unit tests can be run either using the phing build script

    phing test

or running phpunit yourself

    phpunit

Check Digit Formats
===================

 * [Credit Card Number](http://en.wikipedia.org/wiki/Bank_card_number)
 * [Australian Business Number](http://en.wikipedia.org/wiki/Australian_Business_Number)

Planned Support ( Coming Soon )
-------------------------------

 * [Australian Company Number](http://en.wikipedia.org/wiki/Australian_Company_Number)
 * [Australian Tax File Number](http://en.wikipedia.org/wiki/Tax_File_Number)
 * [International Standard Book Number](http://en.wikipedia.org/wiki/International_Standard_Book_Number) ( ISBN-10 , ISBN-13 )
 * [Shipping Container](http://en.wikipedia.org/wiki/ISO_6346) ( ISO 6346 )

Check Digit Algorithms
======================

 * WeightedModulus
 * [Luhn](http://en.wikipedia.org/wiki/Luhn_algorithm)

Planned Support ( Coming Soon )
-------------------------------

 * [Luhn Mod N Algorithm](http://en.wikipedia.org/wiki/Luhn_mod_N_algorithm)
 * [Verhoeff Algorithm](http://en.wikipedia.org/wiki/Verhoeff_algorithm)
