#########
Migration
#########

**********
2.x to 3.x
**********

.. rubric:: Database secret authentication

As Database Secret based authentication has been deprecated by Firebase, it has been removed from this library.
Use Service Account based authentication instead.

.. rubric:: Firebase Factory

Previously, it was possible to create a new Firebase instance with a convenience class in the root namespace.
This class has been removed, and ``Firebase\Factory`` is used instead:

.. code-block:: php

    # Before
    $firebase = \Firebase::fromServiceAccount('/path/to/google-service-account.json');

    # After
    use Firebase\Factory;

    $firebase = (new Factory())
        ->withCredentials('/path/to/google-service-account.json')
        ->create();
