import{d as f,y as G,l as m,o as r,c as v,w as N,a as e,t as o,u as C,m as w,z as L,f as E,g as i,A as F,n,e as c,h as P,F as V}from"./app-DAYWsoxB.js";import{_ as B}from"./GuestLayout-CEdVT8hT.js";import j from"./AddPermutaModal-qcOxSG0v.js";import H from"./CatalogoModal-D3viM9Rz.js";import"./Banner-BpqFt9_w.js";import"./PermutaSent-B6F15UyM.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./EdfTypesCarrousel-DJzCri_W.js";import"./CondicionesCarrousel-Cy6zOLuC.js";const $={class:"grid grid-cols-2 gap-4 items-center"},z={class:"text-sm"},J={class:"font-bold text-sm text-black leading-tight"},Y=e("option",{value:""},"TODOS",-1),Q=e("option",{value:"LUNES"},"Lunes",-1),W=e("option",{value:"MARTES"},"Martes",-1),q=e("option",{value:"MIERCOLES"},"Miércoles",-1),K=e("option",{value:"JUEVES"},"Jueves",-1),X=e("option",{value:"VIERNES"},"Viernes",-1),Z=e("option",{value:"SABADO"},"Sábado",-1),ee=e("option",{value:"DOMINGO"},"Domingo",-1),te=[Y,Q,W,q,K,X,Z,ee],se={class:"py-6"},oe={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},ae={class:"overflow-hidden p-4"},le={class:"flex flex-col gap-4"},re={class:"flex flex-row gap-4 w-3/4"},de={class:"bg-green-600 rounded-lg flex-1 flex flex-col p-4"},ne=e("div",{class:"flex items-center justify-between w-full mb-2"},[e("i",{class:"fa-solid fa-users text-white text-3xl"}),e("span",{class:"bg-white text-green-600 rounded-full px-2 font-bold"},"20%")],-1),ie=e("h3",{class:"text-md text-white"},"Clientes negociados",-1),ce={class:"text-white text-3xl font-bold text-left w-full"},ue={class:"bg-red-600 rounded-lg flex-1 flex flex-col p-4"},fe=e("div",{class:"flex items-center justify-start w-full mb-2"},[e("i",{class:"fa-solid fa-users text-white text-3xl"})],-1),_e=e("h3",{class:"text-md text-white text-left"},"Clientes pendientes",-1),xe={class:"text-white text-3xl font-bold text-left"},ge=e("i",{class:"fa-solid fa-plus mr-2"},null,-1),he=e("i",{class:"fa-solid fa-eye mr-2"},null,-1),Ee={class:"px-2"},be=e("h1",{class:"p-2 font-bold"}," Lista de oportunidad Clientes ",-1),pe={class:"pt-2 relative mx-auto text-gray-600 w-full"},me={class:"flex gap-2 my-4"},ve={class:"p-2 overflow-hidden shadow-xl sm:rounded-lg"},Ce={class:"flex flex-col gap-4"},Ne={class:"bg-white shadow-md rounded-lg overflow-hidden flex"},we={class:"flex-1 border-r border-gray-200"},Oe={class:"p-4"},Ae={class:"text-sm font-semibold"},ye=e("i",{class:"fa-solid fa-user"},null,-1),De={class:"text-sm"},ke=e("i",{class:"fa-solid fa-location-dot"},null,-1),Ie={class:"mt-2"},Te={key:0,class:"bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900"},Se=e("i",{class:"fa-solid fa-fax"},null,-1),Re={key:1,class:"bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900"},Me=e("i",{class:"fa-solid fa-fax"},null,-1),Ue={key:0,class:"flex-1 text-left"},Ge={class:"p-4 text-left"},Le=e("div",{class:"text-sm text-black font-bold"},"Puedes negociar",-1),Fe={class:"text-xs mt-1"},Pe=["href"],Ve=e("i",{class:"fa-brands fa-whatsapp"},null,-1),Be={key:1,class:"flex-1 text-left"},je={class:"p-4 text-left"},He=e("div",{class:"text-sm font-medium text-black font-semibold"},[e("i",{class:"fa-solid fa-circle-check mr-2"}),i("Haz Negociado ")],-1),$e={class:"flex items-center mt-2"},ze={class:"text-xs mt-1"},Je={class:"flex items-center w-full"},Ye=e("i",{class:"fa-solid fa-handshake text-xs"},null,-1),Qe=[Ye],We=e("i",{class:"fa-solid fa-arrows-rotate text-xs"},null,-1),qe=[We],Ke=e("i",{class:"fa-solid fa-check text-xs"},null,-1),Xe=[Ke],Ze={key:0,class:"text-xs text-gray-700 mt-1"},et={key:0,class:"text-red-500 text-lg"},ut={__name:"InfoByRuta",props:{sv:String,ruta:String,clients:Array,negociados:Number,noNegociados:Number,gv:String,cuota:Number,pending:Number},setup(_){const u=_,x=f(""),a=f("todos"),d=f("");let b=f(!1),p=f(!1);const O=()=>["DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO"][new Date().getDay()],A=()=>{b.value=!0},y=()=>{b.value=!1},D=()=>{p.value=!0},k=()=>{p.value=!1},I=()=>{window.location.href=`/gestor/${u.ruta}/permutas`};G(()=>{d.value=O()});const T=m(()=>{let l=new Map;return u.clients.filter(t=>{const g=t.COD_CLIENTE.toLowerCase().includes(x.value.toLowerCase()),M=t.CLIENTE.toLowerCase().includes(x.value.toLowerCase()),U=t.FREC_VISITA.includes(d.value)||d.value==="";let h=!1;return(a.value==="todos"||a.value==="pendientes"&&t.NEGOCIADO==="PENDIENTE"||a.value==="negociados"&&t.NEGOCIADO==="NEGOCIADO")&&(h=!0),!l.has(t.COD_CLIENTE)&&(g||M)&&h&&U?(l.set(t.COD_CLIENTE,!0),!0):!1}).sort((t,g)=>t.NEGOCIADO==="PENDIENTE"&&g.NEGOCIADO!=="PENDIENTE"?-1:t.NEGOCIADO!=="PENDIENTE"&&g.NEGOCIADO==="PENDIENTE"?1:0)}),S=m(()=>{let l=new Map,s=0;return u.clients.forEach(t=>{t.NEGOCIADO==="NEGOCIADO"&&(t.FREC_VISITA.includes(d.value)||d.value==="")&&!l.has(t.COD_CLIENTE)&&(l.set(t.COD_CLIENTE,!0),s++)}),s});m(()=>{let l=new Map,s=0;return u.clients.forEach(t=>{t.NEGOCIADO==="PENDIENTE"&&(t.FREC_VISITA.includes(d.value)||d.value==="")&&!l.has(t.COD_CLIENTE)&&(l.set(t.COD_CLIENTE,!0),s++)}),s});const R=new Date().toLocaleDateString("es-ES",{weekday:"short",year:"numeric",month:"short",day:"numeric"}).replace(/^\w/,l=>l.toUpperCase());return(l,s)=>(r(),v(B,{title:"Dashboard | EDF"},{header:N(()=>[e("div",$,[e("div",null,[e("p",z,o(C(R)),1),e("h2",J," ¡Hola, "+o(u.gv)+"! ",1)]),e("div",null,[w(e("select",{"onUpdate:modelValue":s[0]||(s[0]=t=>d.value=t),class:"block w-full mt-1 border border-gray-100 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 font-bold"},te,512),[[L,d.value]])])])]),default:N(()=>[C(b)?(r(),v(j,{key:0,onClose:y,sv:_.sv,ruta:_.ruta},null,8,["sv","ruta"])):E("",!0),C(p)?(r(),v(H,{key:1,onClose:k})):E("",!0),e("div",se,[e("div",oe,[e("div",ae,[e("div",le,[e("div",re,[e("div",de,[ne,ie,e("p",ce,o(S.value),1)]),e("div",ue,[fe,_e,e("p",xe,o(_.pending),1)])]),e("div",{class:"flex flex-row gap-4"},[e("button",{onClick:A,class:"bg-black text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold"},[ge,i("Ingresar permuta ")]),e("button",{onClick:I,class:"bg-gray-400 text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold"},[he,i("Ver permutas ")]),e("button",{onClick:D,class:"bg-white text-black border-2 border-black px-4 py-1 rounded-lg shadow-lg flex-1 font-bold"}," Ver catálogo EDF ")])])]),e("div",Ee,[be,e("div",pe,[w(e("input",{class:"border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full",type:"search",name:"search",placeholder:"Buscar","onUpdate:modelValue":s[1]||(s[1]=t=>x.value=t)},null,512),[[F,x.value]])]),e("div",me,[e("button",{class:n(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":a.value==="todos","bg-white text-black":a.value!=="todos"}]),onClick:s[2]||(s[2]=t=>a.value="todos")},"Todos",2),e("button",{class:n(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":a.value==="pendientes","bg-white text-black":a.value!=="pendientes"}]),onClick:s[3]||(s[3]=t=>a.value="pendientes")},"No Negociados",2),e("button",{class:n(["px-4 py-1 text-sm rounded-full border-black border-2",{"bg-black text-white":a.value==="negociados","bg-white text-black":a.value!=="negociados"}]),onClick:s[4]||(s[4]=t=>a.value="negociados")},"Negociados",2)])]),e("div",ve,[e("div",Ce,[(r(!0),c(V,null,P(T.value,t=>(r(),c("div",Ne,[e("div",we,[e("div",Oe,[e("div",Ae,[ye,i(" "+o(t.COD_CLIENTE)+" - "+o(t.CLIENTE),1)]),e("div",De,[ke,i(" "+o(t.DIRECCION),1)]),e("div",Ie,[t.N_EDF==0?(r(),c("span",Te,[Se,i(" No cuenta con EDF ")])):(r(),c("span",Re,[Me,i(" Cuenta con "+o(t.N_EDF)+" EDF ",1)]))])])]),t.NEGOCIADO=="PENDIENTE"?(r(),c("div",Ue,[e("div",Ge,[Le,e("div",Fe,"EDF - "+o(t.PUERTAS_A_NEGOCIAR)+" Puertas - "+o(t.CONDICION.charAt(0).toUpperCase()+t.CONDICION.slice(1).toLowerCase()),1),e("a",{href:"https://wa.link/ibba8o",target:"_blank",class:"ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md"},[Ve,i(" Negociar EDF ")],8,Pe)])])):(r(),c("div",Be,[e("div",je,[He,e("div",$e,[e("div",ze,"EDF - "+o(t.PUERTAS_A_NEGOCIAR)+" Puertas - "+o(t.CONDICION.charAt(0).toUpperCase()+t.CONDICION.slice(1).toLowerCase()),1)]),e("ol",Je,[e("li",{class:n([{"text-green-500 dark:text-green-400":t.STATUS==="NEGOCIADO","text-gray-300 dark:text-gray-500":t.STATUS!=="NEGOCIADO"},"flex w-full items-center after:content-[''] after:w-full after:h-0.5 after:border-b after:border-gray-200 after:border-2 after:inline-block dark:after:border-gray-600"])},[e("span",{class:n(["flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0",{"bg-green-50 dark:bg-green-700":t.STATUS==="NEGOCIADO","bg-gray-50 dark:bg-gray-600":t.STATUS!=="NEGOCIADO"}])},Qe,2)],2),e("li",{class:n([{"text-white dark:text-green-400":t.STATUS==="EN RUTA","text-gray-300 dark:text-gray-500":t.STATUS!=="EN RUTA"},"flex w-full items-center after:content-[''] after:w-full after:h-0.5 after:border-b after:border-gray-200 after:border-2 after:inline-block dark:after:border-gray-600"])},[e("span",{class:n(["flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0",{"bg-green-500 dark:bg-green-700":t.STATUS==="EN RUTA","bg-gray-50 dark:bg-gray-600":t.STATUS!=="EN RUTA"}])},qe,2)],2),e("li",{class:n([{"text-green-500 dark:text-green-400":t.STATUS==="ENTREGADO","text-gray-300 dark:text-gray-500":t.STATUS!=="ENTREGADO"},"flex w-full items-center"])},[e("span",{class:n(["flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0",{"bg-green-50 dark:bg-green-700":t.STATUS==="ENTREGADO","bg-gray-50 dark:bg-gray-600":t.STATUS!=="ENTREGADO"}])},Xe,2)],2)]),t.FECHA_PROGRAMACION?(r(),c("div",Ze,[e("strong",null,[i(" F.E: "+o(t.FECHA_PROGRAMACION)+" ",1),new Date(t.FECHA_PROGRAMACION)<new Date?(r(),c("span",et,"!")):E("",!0)])])):E("",!0)])]))]))),256))])])])])]),_:1}))}};export{ut as default};