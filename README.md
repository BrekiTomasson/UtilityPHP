# Utility Function in PHP

This is a simple-to-use and lightweight library that enables calculations using the Utility Function in PHP.


## What is the Utility Function?

The Utility Function is, in simple terms, the average value of a set of possible outcomes, each of which has
their own probability and value. The probabilities of each outcome do not have to add up to 100%, as it is
possible to imagine scenarios where multiple possibilities and outcomes overlap with each other in complex
ways, assuming the way that the value of each possible outcome is treated in the same way. "Value", in this
case, is often going to be considered in monetary terms, but it is equally valid to use any arbitrary scale
of measurement - so long as it is consistent.

## Installation and Usage

To add this library to your project, simply require the package like so:

`composer require brekitomasson/utility-php`

After having required the package in your project, you will be able to create a Utility Function object:

`$utility = new BrekiTomasson\UtilityPHP\Utility;`

Once instantiated as an object, begin adding outcome potentials using this syntax:

`$utility->addOutcome($odds, $value, $text);`

The three parameters are: 

- The `$odds` parameter is entered as a positive number lower than `1`, with `1` being a 100% guarantee that
this outcome will occur. Entering the number `0.001`, for example, is equivalent to entering a value with
a 0.1% possibility of happening.
- The `$value` parameter takes any number - positive or negative. The scale and range is arbitrary; the only
requirement is that you are consistent in the scale and range of the values assigned to all outcomes.
- The `$text` parameter is optional and takes a string that describes the particular parameter. This is not
used in the final calculations and will only be used as reference while constructing the Utility Function. As
such, it can safely be ignored.

When adding an outcome using the `addOutcome()` method, the current value of all outcomes that have been
entered is calculated and returned. If you want to get the total value at any other point, simply run the
method `$utility->getValue();`.

To list the various outcomes added, enter `$utility->listOutcomes();`. This will return an array of the
various outcomes that have been entered, each with an index value starting in 0. This index value can be
used in these two methods:

- To delete an already entered outcome, enter `$utility->removeOutcome($index);`
- To change an already entered outcome, enter `$utility->alterOutcome($index, $odds, $value, $text);`

> **Note**: The index is regenerated when using `removeOutcome()`, so that it will always be consecutive
and zero-based.

If you wish to enter outcomes in bulk, `$utility->addOutcomes($array);` is possible, assuming an array
which is constructed like so:

```
[
  [$odds, $value, $text],
  [$odds, $value, $text],
  [$odds, $value, $text],
  ...
]
```

As before, the `$text` parameter is optional, so `addOutcomes()` will accept `[[0.5, 10], [0.1, -1], [0.84, 3]]`
as valid input.

Entering outcomes in bulk is also possible when constructing the Utility Function object in the first
place, using the syntax `$utility = new BrekiTomasson\UtilityPHP\Utility($array);`, with an array
formatted in the same way as the one used in the `addOutcomes()` method.

## Usage Example 

Let's consider an example. Say that I'm considering selling my apartment and moving to a new one in a
different part of the same city. Having looked at the market and considered my options, I've jotted down a
list of ten potential pros and cons, each with their own probability and value. For simplicity, I've put the
value of each possibility on a scale from -10 to +10, with -10 being terrible, 0 being neutral and +10 being
wonderful. The various potentials are:

1. 20% - I get significantly less for my current apartment than I think: -5
2. 10% - I get significantly more for my current apartment than I think: +6
3. 25% - The apartment I move to will be more expensive than planned: -6
4. 5% - I find an apartment for significantly less than planned: +8
5. 20% - The apartment I find requires significant renovation: -4
6. 5% - The apartment I find requires no renovation at all: +3
7. 30% - Monthly costs for maintenance/upkeep will increase: -4
8. 5% - Monthly costs for maintenance/upkeep will decrease: +6
9. 100% - I lose the comfort and familiarity of my current apartment: -2
10. 5% - Something important to me breaks or is lost during the move: -5

As you can see, many of these potentials are mutually exclusive, the totals don't add up to 100%, and a
number of neutral possibilities - such as the 70% of getting exactly what I expect from selling my current
apartment - are not listed, just implied.

When adding up these ten outcome potentials, the Utility Function tells me that the total value for them
all is equal to -5.3. While the best-case outcome might be great, the average expected value is not, so I
might want to reconsider moving, or possibly adding more outcome potentials to the list to get a more
nuanced picture of what's going on.

Using this library to calculate the same thing might look like this:

```
$values = [
  [0.2, -5, 'less at sale'],
  [0.1, 6, 'more at sale'],
  [0.25, -6, 'more expensive buy'],
  [0.05, 8, 'less expensive buy'],
  [0.2, -4, 'significant renovation required'],
  [0.05, 3, 'no renovation required'],
  [0.3, -4, 'upkeep goes up'],
  [0.05, 6, 'upkeep goes down'],
  [1, -2, 'familiarity goes away'],
  [0.05, -5, 'stuff breaks during move']
];

$utility = new BrekiTomasson\UtilityPHP\Utility($values);

echo $utility->getValue();

```
