<?php

function generate_order_id()
{
    // Generate a random word
    $random_word = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 5)), 0, 5);

    // Generate a timestamp
    $timestamp = time();

    // Combine them to create the order ID
    $order_id = $timestamp . '_' . $random_word;

    return $order_id;
}
