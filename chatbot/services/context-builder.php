<?php

function buildContext()
{
    return <<<TEXT
========================
CURRENT SYSTEM CONTEXT
========================

Pet Information
---------------
Pet Name: Bella
Species: Dog
Breed: Golden Retriever

Boarding
---------
Status: Checked In

Feeding
--------
Breakfast: Completed
Lunch: Completed
Dinner: Scheduled (6:00 PM)

Smart Feeder
------------
Food Level: 78%
Water Level: 61%

Instructions
------------
Treat all information above as the latest system data.
If the user asks about these values, answer using this context.
If they ask about information not listed, state that it isn't currently available rather than inventing an answer.

TEXT;
}