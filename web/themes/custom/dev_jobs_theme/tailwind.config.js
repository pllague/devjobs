/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["**/*.twig", "../../../modules/dev_jobs/**/*.twig"],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        s_violet: "#5964E0",
        l_violet: "#939BF4",
        l_gray: "#F4F6F8",
        m_gray: "#9DAEC2",
        d_gray: "#6E8098",
        d_blue: "#19202D",
        d_black: "#121721",
        l_orange: "#E99210"
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
