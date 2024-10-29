/** @type {import('tailwindcss').Config} */
export default {
  content: [
	'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
	'./storage/framework/views/*.php',
	'./resources/views/**/*.blade.php',
	'./resources/js/**/*.vue',
  'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
  'node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
  ],
  theme: {
	extend: {screens: {/* '3xs' : '320px',  */'xxs' : '480px'/* , 'xs' : '540px', */}},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

