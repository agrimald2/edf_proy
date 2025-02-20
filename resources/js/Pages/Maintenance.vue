<template>
    <div class="maintenance-page">
      <img src="https://nedfac.com/logo.png" alt="AC Equipos Logo" class="logo">
      <h1>¡Volveremos pronto!</h1>
      <p>Disculpa las molestias, pero estamos realizando un mantenimiento en este momento. ¡Estaremos operativos nuevamente en breve!</p>
      <p class="signature">&mdash; AC Equipos</p>
      <div class="icons">
        <i class="fas fa-tools"></i>
        <i class="fas fa-clock"></i>
        <i class="fas fa-sync-alt"></i>
      </div>
    </div>
  </template>
  
  <style scoped>
  .maintenance-page {
    background-color: #F5F5F5;
    color: #c41c39;
    text-align: center;
    padding: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  
  .maintenance-page .logo {
    max-width: 200px;
    margin-bottom: 20px;
  }
  
  h1 {
    font-size: 50px;
    color: #c41c39;
  }
  
  .signature {
    margin-top: 20px;
  }
  
  .icons {
    margin-top: 30px;
    font-size: 24px;
  }
  
  .icons i {
    margin: 0 10px;
  }
  </style>