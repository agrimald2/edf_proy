import{_ as v}from"./GuestLayout-BbVyc81T.js";import m from"./PermutaDetails-gByxWpkL.js";import{j as w,l as _,o as i,c as h,w as y,f as c,a as e,m as g,y as k,g as u,t as n,s as P,n as d,e as f,h as j,F as C}from"./app-BvT6hsxr.js";import M from"./AddPermutaModal-ohe7m3qI.js";import{_ as A}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Banner-CUJE08-z.js";import"./PermutaSent-B0Ui1O0f.js";const D={components:{GuestLayout:v,PermutaDetails:m,AddPermutaModal:M},props:["supervisor","route","sv","gv","location_id"],data(){const s={0:"enero",1:"febrero",2:"marzo",3:"abril",4:"mayo",5:"junio",6:"julio",7:"agosto",8:"septiembre",9:"octubre",10:"noviembre",11:"diciembre"},o=new Date().getMonth();return{todaysDate:new Date().toLocaleDateString("es-ES",{weekday:"short",year:"numeric",month:"short",day:"numeric"}).replace(/^\w/,a=>a.toUpperCase()),selectedFilter:"todos",selectedMonth:s[o],permutas:[],searchQuery:"",showDetailModal:!1,selectedPermuta:null,showAddPermutaModal:!1}},computed:{filteredPermutas(){return this.permutas.filter(s=>this.selectedFilter==="todos"?!0:this.selectedFilter==="rejected"?s.trade_status.toLowerCase()==="rejected"||s.supervisor_status.toLowerCase()==="rejected"||s.gerente_status.toLowerCase()==="rejected":this.selectedFilter==="pending"?s.trade_status.toLowerCase()==="pending"&&s.supervisor_status.toLowerCase()!=="rejected"&&s.gerente_status.toLowerCase()!=="rejected":s.trade_status.toLowerCase()===this.selectedFilter).filter(s=>{if(this.selectedMonth!=="todos"){const o={enero:0,febrero:1,marzo:2,abril:3,mayo:4,junio:5,julio:6,agosto:7,septiembre:8,octubre:9,noviembre:10,diciembre:11};if(new Date(s.created_at).getMonth()!==o[this.selectedMonth])return!1}return s.cod_cliente.includes(this.searchQuery)||s.location.name.includes(this.searchQuery)})},approvedCount(){return this.permutas.filter(s=>s.trade_status.toLowerCase()==="approved").length},pendingCount(){return this.permutas.filter(s=>s.trade_status.toLowerCase()==="pending"&&s.supervisor_status.toLowerCase()!=="rejected"&&s.gerente_status.toLowerCase()!=="rejected").length}},methods:{async getPermutas(){try{const s=await w.get(`/api/gestor/${this.route}/permutas`);this.permutas=s.data}catch(s){console.error("Error fetching permutas:",s)}},statusClass(s){switch(s.toLowerCase()){case"approved":return"bg-green-100 text-green-800";case"rejected":return"bg-red-100 text-red-800";case"pending":return"bg-yellow-100 text-yellow-800";default:return"bg-gray-100 text-gray-800"}},statusIcon(s){switch(s.toLowerCase()){case"approved":return"fa-solid fa-check";case"rejected":return"fa-solid fa-x";case"pending":return"fa-solid fa-spinner";default:return"fa-solid fa-question"}},openDetailModal(s){console.log("Opening detail modal for permuta ID:",s),this.selectedPermuta=this.permutas.find(o=>o.id===s),this.showDetailModal=!0},closeDetailModal(){console.log("Closing detail modal"),this.showDetailModal=!1,this.selectedPermuta=null},goBack(){window.history.back()},goToPendingPermutas(){window.location.href=`/gestor/${this.route}/dashboard/permutas/pending`},openAddPermutaModal(){this.showAddPermutaModal=!0},closeAddPermutaModal(){this.showAddPermutaModal=!1}},mounted(){this.getPermutas()}},F={class:"flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200"},L=e("i",{class:"fa-solid fa-chevron-left font-bold"},null,-1),R=[L],z=e("h3",{class:"text-center text-sm font-bold text-gray-800 flex-1"},"Permutas",-1),B={class:"flex items-center"},S=e("label",{class:"text-xs font-semibold mr-2"},"Mes:",-1),T=e("option",{value:"todos"},"Todos",-1),V=e("option",{value:"enero"},"Ene",-1),E=e("option",{value:"febrero"},"Feb",-1),Q=e("option",{value:"marzo"},"Mar",-1),G=e("option",{value:"abril"},"Abr",-1),N=e("option",{value:"mayo"},"May",-1),U=e("option",{value:"junio"},"Jun",-1),q=e("option",{value:"julio"},"Jul",-1),I=e("option",{value:"agosto"},"Ago",-1),J=e("option",{value:"septiembre"},"Sep",-1),O=e("option",{value:"octubre"},"Oct",-1),H=e("option",{value:"noviembre"},"Nov",-1),K=e("option",{value:"diciembre"},"Dic",-1),W=[T,V,E,Q,G,N,U,q,I,J,O,H,K],X={class:"flex flex-row gap-2 bg-white shadow-md rounded-lg overflow-hidden p-2 items-center"},Y={class:"flex-1 text-center text-xs"},Z=e("span",{class:"font-bold"}," Aprobadas: ",-1),$={class:"flex-1 text-center text-xs text-black"},ee=e("span",{class:"font-bold"},"Pendientes: ",-1),te={class:"px-2 flex justify-between items-center my-4"},se=e("h2",{class:"font-bold text-sm text-black leading-tight"}," Lista de Permutas ",-1),oe=e("i",{class:"fa-solid fa-plus mr-2"},null,-1),re={class:"px-2"},de={class:"relative text-gray-600 w-full"},le={class:"flex gap-1 my-2 px-1"},ne={class:"p-2 overflow-hidden shadow-xl sm:rounded-lg"},ie={class:"flex flex-col gap-4"},ae={class:"w-3/5 border-r border-gray-200"},ce={class:"p-4"},ue={class:"text-sm font-semibold"},fe=e("i",{class:"fa-solid fa-user"},null,-1),_e={class:"text-xs flex items-center justify-between"},he={key:0},ge={key:1},xe={key:2},pe={class:"bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4"},be=e("i",{class:"fa-brands fa-square-letterboxd"},null,-1),ve={class:"flex items-center mt-2 pl-2"},me={class:"flex flex-col items-center"},we={class:"flex flex-col items-center"},ye={class:"flex flex-col items-center"},ke=e("div",{class:"flex justify-between mt-2"},[e("div",{class:"text-xs font-medium text-gray-500"},"Supervisor"),e("div",{class:"text-xs font-medium text-gray-500 pr-5"},"Gerente"),e("div",{class:"text-xs font-medium text-gray-500"},"Trade")],-1),Pe={class:"w-2/5 text-left"},je={class:"pb-2 px-4 text-left pt-2"},Ce={class:"text-sm text-black font-bold"},Me={class:"text-xs mt-1 font-medium text-gray-500"},Ae={class:"text-xs font-medium text-gray-500 mt-4"},De=["onClick"];function Fe(s,o,a,Le,r,l){const x=_("AddPermutaModal"),p=_("PermutaDetails"),b=_("GuestLayout");return i(),h(b,{title:"Permutas | EDF"},{default:y(()=>[r.showAddPermutaModal?(i(),h(x,{key:0,onClose:l.closeAddPermutaModal,sv:a.sv,ruta:a.route,location_id:a.location_id},null,8,["onClose","sv","ruta","location_id"])):c("",!0),e("div",F,[e("button",{onClick:o[0]||(o[0]=t=>l.goBack()),class:"text-black text-sm hover:text-gray-800"},R),z,e("div",B,[S,g(e("select",{"onUpdate:modelValue":o[1]||(o[1]=t=>r.selectedMonth=t),class:"border border-gray-300 rounded-md text-xs p-1 px-2"},W,512),[[k,r.selectedMonth]])])]),e("div",X,[e("div",Y,[Z,u(" "+n(l.approvedCount),1)]),e("div",$,[ee,u(" "+n(l.pendingCount),1)])]),e("div",te,[se,e("button",{onClick:o[2]||(o[2]=(...t)=>l.openAddPermutaModal&&l.openAddPermutaModal(...t)),class:"bg-black text-white px-2 py-1 rounded-lg shadow-lg font-bold ml-auto"},[oe,u("Ingresar permuta ")])]),e("div",re,[e("div",de,[g(e("input",{class:"border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full",type:"search",name:"search",placeholder:"Buscar","onUpdate:modelValue":o[3]||(o[3]=t=>r.searchQuery=t)},null,512),[[P,r.searchQuery]])])]),e("div",le,[e("button",{class:d(["px-1 py-0.5 text-xxs rounded-full border-black border",{"bg-black text-white":r.selectedFilter==="todos","bg-white text-black":r.selectedFilter!=="todos"}]),onClick:o[4]||(o[4]=t=>r.selectedFilter="todos"),style:{"font-size":"13px"}},"Todos",2),e("button",{class:d(["px-1 py-0.5 text-xxs rounded-full border-black border",{"bg-black text-white":r.selectedFilter==="approved","bg-white text-black":r.selectedFilter!=="approved"}]),onClick:o[5]||(o[5]=t=>r.selectedFilter="approved"),style:{"font-size":"13px"}},"Aprobadas",2),e("button",{class:d(["px-1 py-0.5 text-xxs rounded-full border-black border",{"bg-black text-white":r.selectedFilter==="rejected","bg-white text-black":r.selectedFilter!=="rejected"}]),onClick:o[6]||(o[6]=t=>r.selectedFilter="rejected"),style:{"font-size":"13px"}},"Rechazadas",2),e("button",{class:d(["px-1 py-0.5 text-xxs rounded-full border-black border",{"bg-black text-white":r.selectedFilter==="pending","bg-white text-black":r.selectedFilter!=="pending"}]),onClick:o[7]||(o[7]=t=>r.selectedFilter="pending"),style:{"font-size":"13px"}},"Pendientes",2)]),e("div",ne,[e("div",ie,[(i(!0),f(C,null,j(l.filteredPermutas,t=>(i(),f("div",{key:t.id,class:"bg-white shadow-md rounded-lg overflow-hidden flex flex-row"},[e("div",ae,[e("div",ce,[e("div",ue,[fe,u(" "+n(t.cod_cliente)+" - "+n(t.location.name),1)]),e("div",_e,[e("div",{class:d({"bg-green-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4":t.trade_status==="Approved","bg-red-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4":t.trade_status==="Rejected","bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4":t.trade_status==="Pending"})},[e("i",{class:d({"fa-solid fa-check text-green-500":t.trade_status==="Approved","fa-solid fa-times text-red-500":t.trade_status==="Rejected","fa-solid fa-clock text-gray-500":t.trade_status==="Pending"})},null,2),t.trade_status==="Approved"?(i(),f("span",he," Aprobado")):c("",!0),t.trade_status==="Rejected"?(i(),f("span",ge," Rechazado")):c("",!0),t.trade_status==="Pending"?(i(),f("span",xe," Pendiente")):c("",!0)],2),e("div",pe,[be,u(" "+n(t.volume)+" CU ",1)])]),e("div",ve,[e("div",me,[e("div",{class:d({"w-8 h-8 flex items-center justify-center rounded-full bg-green-500":t.supervisor_status==="Approved","w-8 h-8 flex items-center justify-center rounded-full bg-red-500":t.supervisor_status==="Rejected","w-8 h-8 flex items-center justify-center rounded-full bg-gray-300":t.supervisor_status==="Pending"})},[e("i",{class:d({"fa-solid fa-check text-white":t.supervisor_status==="Approved","fa-solid fa-times text-white":t.supervisor_status==="Rejected","fa-solid fa-clock text-gray-400":t.supervisor_status==="Pending"})},null,2)],2)]),e("div",{class:d({"h-1 w-16 bg-green-500":t.supervisor_status==="Approved","h-1 w-16 bg-red-500":t.supervisor_status==="Rejected","h-1 w-16 bg-gray-300":t.supervisor_status==="Pending"})},null,2),e("div",we,[e("div",{class:d({"w-8 h-8 flex items-center justify-center rounded-full bg-green-500":t.gerente_status==="Approved","w-8 h-8 flex items-center justify-center rounded-full bg-red-500":t.gerente_status==="Rejected","w-8 h-8 flex items-center justify-center rounded-full bg-gray-300":t.gerente_status==="Pending"})},[e("i",{class:d({"fa-solid fa-check text-white":t.gerente_status==="Approved","fa-solid fa-times text-white":t.gerente_status==="Rejected","fa-solid fa-clock text-gray-400":t.gerente_status==="Pending"})},null,2)],2)]),e("div",{class:d({"h-1 w-16 bg-green-500":t.gerente_status==="Approved","h-1 w-16 bg-red-500":t.gerente_status==="Rejected","h-1 w-16 bg-gray-300":t.gerente_status==="Pending"})},null,2),e("div",ye,[e("div",{class:d({"w-8 h-8 flex items-center justify-center rounded-full bg-green-500":t.trade_status==="Approved","w-8 h-8 flex items-center justify-center rounded-full bg-red-500":t.trade_status==="Rejected","w-8 h-8 flex items-center justify-center rounded-full bg-gray-300":t.trade_status==="Pending"})},[e("i",{class:d({"fa-solid fa-check text-white":t.trade_status==="Approved","fa-solid fa-times text-white":t.trade_status==="Rejected","fa-solid fa-clock text-gray-400":t.trade_status==="Pending"})},null,2)],2)])]),ke])]),e("div",Pe,[e("div",je,[e("div",Ce," Ruta: "+n(t.route),1),e("div",Me,n(t.condition)+" - "+n(t.doors_to_negotiate)+" "+n(t.doors_to_negotiate===1?"Puerta":"Puertas"),1),e("div",Ae,[e("button",{class:"bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full",onClick:Re=>l.openDetailModal(t)},"Ver Detalles",8,De)])])])]))),128))])]),r.showDetailModal?(i(),h(p,{key:1,show:r.showDetailModal,permuta:r.selectedPermuta,id:`Permuta${r.selectedPermuta.id}`,onClose:l.closeDetailModal},null,8,["show","permuta","id","onClose"])):c("",!0)]),_:1})}const Ge=A(D,[["render",Fe]]);export{Ge as default};