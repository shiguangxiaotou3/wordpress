#!/usr/bin/env bash

FONT1="https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-ultralight-webfont.woff2"
FONT2="https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-thin-webfont.woff2"
FONT3="https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff2"
FONT4="https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-bold-webfont.woff2"
SCV="https://file.myfontastic.com/bLfXNBF36ByeujCbT5PohZ/sprites/1477146123.svg"


wget -P  static/fonts/ "$FONT1"
wget -P  static/fonts/ "$FONT2"
wget -P  static/fonts/ "$FONT3"
wget -P  static/fonts/ "$FONT4"
wget -P  static/svg/ "$SCV"