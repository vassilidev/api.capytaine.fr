<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:extract-rss-news-from-sources')->everyFifteenMinutes();