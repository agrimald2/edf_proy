import{_ as p}from"./GuestLayout-CEdVT8hT.js";import{i as m,o as r,c as f,w as u,a as e,t as l,g as a,m as g,A as b,n as d,e as c,h as _,f as v,F as h}from"./app-DAYWsoxB.js";import{_ as y}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Banner-BpqFt9_w.js";const w={props:{mesa:String,clients:Array,negociados:Number,noNegociados:Number,gv:String,cuota:Number,pending:Number,supervisor:String},components:{GuestLayout:p},data(){return{todaysDate:new Date().toLocaleDateString("es-ES",{weekday:"short",year:"numeric",month:"short",day:"numeric"}).replace(/^\w/,i=>i.toUpperCase()),selectedFilter:"todos",searchQuery:""}}},k={class:"grid grid-cols-2 gap-4 items-center"},N={class:"text-sm"},F={class:"font-bold text-sm text-black leading-tight"},C=e("div",{class:"flex items-center",style:{"margin-left":"auto"}},[e("span",{class:"text-xs font-bold"},"Frecuencia:"),e("select",{style:{"padding-right":"2rem"},class:"block mt-1 border-none rounded focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"},[e("option",{value:"lunes"},"Lunes"),e("option",{value:"martes"},"Martes"),e("option",{value:"miércoles"},"Miércoles"),e("option",{value:"jueves"},"Jueves"),e("option",{value:"viernes"},"Viernes"),e("option",{value:"sábado"},"Sábado"),e("option",{value:"domingo"},"Domingo")])],-1),S=e("div",{class:"py-6"},[e("div",{class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},[e("div",{class:"overflow-hidden px-4"},[e("div",{class:"flex flex-col gap-4"},[e("div",{class:"flex flex-row gap-4 w-2/5"},[e("div",{class:"bg-green-600 rounded-lg flex-1 flex flex-col p-4"},[e("div",{class:"flex items-center justify-between w-full mb-2"},[e("i",{class:"fa-solid fa-users text-white text-3xl"}),e("span",{class:"bg-white text-green-600 rounded px-2 font-bold"},"20%")]),e("h3",{class:"text-md text-white"},"Avance de Cuota"),e("p",{class:"text-white text-3xl font-bold text-left w-full"}," 3/21")])])])])])],-1),E={class:"px-2 mb-4"},D=e("i",{class:"fa-solid fa-book mr-2"},null,-1),T={class:"px-2"},A={class:"relative mx-auto text-gray-600 w-full"},L={class:"flex gap-2 my-4 px-2"},U={class:"p-2 overflow-hidden shadow-xl sm:rounded-lg"},B={class:"flex flex-col gap-4"},R={key:0,class:"absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-tr-lg"},V={class:"flex-1 border-r border-gray-200"},M={class:"p-4"},P={class:"text-sm font-semibold"},G=e("i",{class:"fa-solid fa-user"},null,-1),Q={class:"text-xs pt-2 pl-4"},j=e("span",{class:"font-bold"}," Clientes Negociados: ",-1),I={class:"flex-1 text-left"},z={class:"p-4 text-left"},H=e("div",{class:"text-sm text-black font-bold"},"Puertas negociadas",-1),J={class:"text-xs mt-1 font-medium text-gray-500"},q={class:"text-xs font-medium text-gray-500"};function K(i,o,n,O,s,W){const x=m("GuestLayout");return r(),f(x,{title:"Mesa | EDF"},{header:u(()=>[e("div",k,[e("div",null,[e("p",N,l(s.todaysDate),1),e("h2",F," ¡Hola, "+l(n.supervisor)+"! ",1)]),C])]),default:u(()=>[S,e("div",E,[e("button",{onClick:o[0]||(o[0]=t=>i.$inertia.get(i.route("supervisor.permutas.list",{mesa:n.mesa}))),class:"bg-black text-white py-1 px-4 rounded-md flex items-center"},[D,a(" Ver permutas ")])]),e("div",T,[e("div",A,[g(e("input",{class:"border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full",type:"search",name:"search",placeholder:"Buscar","onUpdate:modelValue":o[1]||(o[1]=t=>s.searchQuery=t)},null,512),[[b,s.searchQuery]])])]),e("div",L,[e("button",{class:d(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":s.selectedFilter==="todos","bg-white text-black":s.selectedFilter!=="todos"}]),onClick:o[2]||(o[2]=t=>s.selectedFilter="todos")},"Todos",2),e("button",{class:d(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":s.selectedFilter==="pendientes","bg-white text-black":s.selectedFilter!=="pendientes"}]),onClick:o[3]||(o[3]=t=>s.selectedFilter="pendientes")},"No Negociados",2),e("button",{class:d(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":s.selectedFilter==="negociados","bg-white text-black":s.selectedFilter!=="negociados"}]),onClick:o[4]||(o[4]=t=>s.selectedFilter="negociados")},"Negociados",2)]),e("div",U,[e("div",B,[(r(!0),c(h,null,_(n.clients,t=>(r(),c("div",{key:t.id,style:{position:"relative"},class:d(["bg-white shadow-md rounded-lg overflow-hidden flex",{"border-red-500 border-2":t.N_PUERTAS==0}])},[t.N_PUERTAS==0?(r(),c("div",R," ! ")):v("",!0),e("div",V,[e("div",M,[e("div",P,[G,a(" "+l(t.RUTA)+" "+l(t.CLIENTE),1)]),e("div",Q,[j,a(" "+l(t.N_PUERTAS),1)])])]),e("div",I,[e("div",z,[H,e("div",J," Repotenciadas: "+l(t.N_EDF),1),e("div",q," Nuevas: "+l(t.N_PUERTAS),1)])])],2))),128))])])]),_:1})}const ee=y(w,[["render",K]]);export{ee as default};