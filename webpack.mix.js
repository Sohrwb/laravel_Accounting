const mix = require('laravel-mix');

mix.react('resources/js/calendar-component/index.jsx', 'public/js')
   .setPublicPath('public');
