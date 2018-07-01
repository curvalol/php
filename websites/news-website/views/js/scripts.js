(function () {
  const 
    w = window.innerHeight,
    wr = document.querySelector('.wrapper'),
    h = document.querySelector('.header').clientHeight,
    f = document.querySelector('.footer').clientHeight,
    m = document.querySelector('.main');

  wr.style.minHeight = (w - f) + 'px';
  m.style.minHeight = (w - h - f) + 'px';


})();