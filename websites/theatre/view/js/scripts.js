(function() {
  const 
    wrapper = document.querySelector('.wrapper'),
    header = document.querySelector('.header'),
    footer = document.querySelector('.footer'),
    main = document.querySelector('main'),
    mainContainer = main.querySelector('.container');
  
  const resize = window.setTimeout(mainElementsResize, 500);

  mainElementsResize();
  window.addEventListener('resize', e => {
    mainElementsResize(e);
  })

  if (document.querySelector('.tab_button')) {
    const
      ticket_tab_container = document.querySelector('.userTickets'),
      inform_tab_container = document.querySelector('.userInformation');
      ticket_tab = document.querySelector('.tickets_tab'),
      inform_tab = document.querySelector('.info_tab');

    ticket_tab.addEventListener('click', e => {
      if (!ticket_tab.classList.contains('active')) {
        ticket_tab.classList.add('active');
        inform_tab.classList.remove('active');
        ticket_tab_container.classList.remove('disabled');
        inform_tab_container.classList.add('disabled');
      }
    })

    inform_tab.addEventListener('click', e => {
      if (!inform_tab.classList.contains('active')) {
        inform_tab.classList.add('active');
        ticket_tab.classList.remove('active');
        inform_tab_container.classList.remove('disabled');
        ticket_tab_container.classList.add('disabled');
      }
    })
  }

  if (document.querySelector('.seats')) {
    const
      seatsContainer = document.querySelector('.seats');
      seats = Array.prototype.slice.call(seatsContainer.querySelectorAll('.seat:not(.disabled)'));

    seats.forEach(el => {
      const
        inp = el.querySelector('input.seatBox');

      if (inp.checked) {
        el.classList.add('checked');
      }
    })

    seatsContainer.addEventListener('click', checkClickHandler);

    function checkClickHandler(e) {
      const
        target = e.target;

      if (target.classList.contains('seat') && !target.classList.contains('disabled')) {
        target.classList.toggle('checked');
      }
    }    
  }

  function mainElementsResize(e) {
    wrapper.style.height = window.innerHeight + 'px';
    wrapper.style.minHeight = (header.offsetHeight + mainContainer.offsetHeight + footer.offsetHeight) + 'px';
    main.style.minHeight = mainContainer.offsetHeight + 'px';
    main.style.height = (window.innerHeight - footer.offsetHeight - header.offsetHeight) + 'px';
  }
})();