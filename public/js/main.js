'use strict';

// function counter() {
//   let seconds = 0;
//   setInterval(() => {
//     seconds += 1;
//     document.getElementById('app').innerHTML = `<p>You have been here for ${seconds} seconds.</p>`;
//   }, 1000);
// }

// document.querySelector('.root-nav').addEventListener("mousemove", function(){console.log(123);});

function myFunction() {
  document.getElementById("demo").innerHTML = Math.random();
}
let onMenu = false;
document.querySelector('.root-nav').onmouseover = function(event){
  console.log(onMenu);
  if (event.target.nodeName !== 'SPAN') return;
  onMenu = true;
  closeAllSubMenu(event.target.nextElementSibling);
  event.target.classList.add('sub-menu-active-span');
  event.target.nextElementSibling.classList.add('sub-menu-active');
}

document.querySelector('.root-nav').onmouseout = function(event){
  console.log(onMenu);
  if (event.target.nodeName !== 'SPAN'){
    
    return;
  }
  if(onMenu){
    onMenu = false;
    return;
  }
  if(!onMenu){
    console.log(123)
    onMenu = false;
    closeAll();
  }
  
  // event.target.classList.add('sub-menu-active-span');
  // event.target.nextElementSibling.classList.toggle('sub-menu-active');
}


document.querySelector('.main').onmouseover = function(event){
  closeAll();
}

document.querySelector('.link').onmouseover = function(event){
  closeAll();
}


function closeAll(){
  const subMenu = document.querySelectorAll('.root-nav ul');
  Array.from(subMenu).forEach(item => {
    item.classList.remove('sub-menu-active');
    if(item.previousElementSibling.nodeName === 'SPAN') item.previousElementSibling.classList.remove('sub-menu-active-span');
  });
}

function closeAllSubMenu(current){
  let parents = [];
  if (current){
    let currentParent = current.parentNode;
    while(currentParent){
      if (currentParent.classList.contains('root-nav')) break;
      if (currentParent.nodeName === 'UL') parents.push(currentParent);
      currentParent = currentParent.parentNode;
    }
  }

  const subMenu = document.querySelectorAll('.root-nav ul');
  Array.from(subMenu).forEach(item => {
    if(item != current && !parents.includes(item)) {
      item.classList.remove('sub-menu-active');
      if(item.previousElementSibling.nodeName === 'SPAN') item.previousElementSibling.classList.remove('sub-menu-active-span');
    }
  });
}
