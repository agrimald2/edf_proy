import{d as l,o as i,c,w as d,a as e,j as u,k as f,v as p,g as r}from"./app-CdoPr1dZ.js";import{_ as m}from"./GuestLayout-BbJ57Dyj.js";import"./Banner-Cg02jEoR.js";const h={class:"flex items-center justify-center h-screen"},x={class:"w-full max-w-xs"},_=e("div",{class:"text-center flex justify-center my-4"},[e("img",{src:"/logo.png",alt:"",style:{width:"65%"}})],-1),g={class:"mb-4 mt-6"},w=e("p",{class:"text-sm text-gray-500 mt-2",style:{"font-size":"12px"}},[e("i",{class:"fa-solid fa-circle-info"}),r(" Ejem. Gestor: I9H47 / Supervisor: I9SV04")],-1),v=e("button",{class:"w-full bg-red-arca hover:bg-red-700 text-white py-2 px-4 rounded-lg flex items-center justify-center focus:outline-none focus:shadow-outline",type:"submit"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-5 w-5 mr-2",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"})]),r(" Ingresar ")],-1),b=e("div",{class:"mt-4 text-center"},[e("a",{href:"/login",class:"text-sm text-blue-300 hover:text-blue-500"}," Acceso Gerente/Trade ")],-1),B={__name:"Search",setup(y){const t=l(""),a=()=>{const s=`/login/${t.value}`;window.location.href=s};return(s,o)=>(i(),c(m,{title:"Ingresar | EDF"},{default:d(()=>[e("div",h,[e("div",x,[e("form",{onSubmit:u(a,["prevent"]),class:"bg-white px-8 pt-6 pb-4 mb-4"},[_,e("div",g,[f(e("input",{"onUpdate:modelValue":o[0]||(o[0]=n=>t.value=n),class:"shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-300",placeholder:"Ingresa tu código"},null,512),[[p,t.value]]),w]),v,b],32)])])]),_:1}))}};export{B as default};