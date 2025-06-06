/** @type {import('tailwindcss').Config} */
export default {
  content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
        './vendor/livewire/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        accent: '#1fa37a',
        'accent-foreground': '#ffffff',
      },
    },
  },
  plugins: [],
}
