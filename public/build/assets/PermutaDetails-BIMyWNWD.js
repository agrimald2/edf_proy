import{_ as u}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{o as r,e as c,a as e,t as s,f as d,g as o}from"./app-BQYf19F4.js";const m={props:{show:{type:Boolean,default:!1},permuta:{type:Object,required:!0},haveAvailableLimit:{type:Boolean,default:!0},sv:{type:String}},data(){return{formData:{date:new Date(this.permuta.created_at).toLocaleDateString("es-ES",{year:"numeric",month:"long",day:"numeric"}),clientCode:this.permuta.cod_cliente,volumeCU:this.permuta.volume,location:this.permuta.location.name,route:this.permuta.route,subcanal:this.permuta.subcanal,haveEdf:this.permuta.have_edf,doorsToNegotiate:this.permuta.doors_to_negotiate,condition:this.permuta.condition,reason:this.permuta.reason,justification:this.permuta.justification},reasons:[],sentPermutaViewModal:!1,errorMessage:"",isSubmitting:!1,showDetails:!0}},mounted(){fetch("/api/permuta-reasons").then(a=>a.json()).then(a=>{this.reasons=a}).catch(a=>{console.error("Error fetching reasons:",a)})},methods:{detailsModal(){console.log("A"),this.showDetails=!0},closeModal(){this.$emit("close"),this.detailsModal()}}},p={class:"z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center"},h={class:"bg-white rounded-lg shadow-lg w-96 p-6 relative"},f=e("i",{class:"fa-solid fa-circle-xmark text-gray-500"},null,-1),_=[f],g={key:0},b=e("div",{class:"text-center mb-10 pt-2"},[e("h2",{class:"text-lg font-bold"},"Detalles de Permuta"),e("p",null,"Revisa la información de la permuta")],-1),v={key:0,class:"text-red-500 text-center mb-4"},D={class:"space-y-2"},y=e("p",{class:"font-semibold mb-2"},"Información del cliente",-1),x={class:"space-y-2"},M=e("span",{class:"font-medium"},"Código de cliente:",-1),C=e("span",{class:"font-medium"},"Fecha de permuta:",-1),w=e("span",{class:"font-medium"},"Volumen en CU:",-1),k=e("span",{class:"font-medium"},"Locación:",-1),j=e("span",{class:"font-medium"},"Ruta:",-1),S=e("span",{class:"font-medium"},"Subcanal:",-1),B=e("p",{class:"font-semibold mt-4"},"EDF a solicitar",-1),E=e("span",{class:"font-medium"},"Condición:",-1),N=e("span",{class:"font-medium"},"Puertas a negociar:",-1),V=e("span",{class:"font-medium"},"Motivo:",-1),P=e("span",{class:"font-medium"},"Justificación:",-1),L={class:"mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium"};function T(a,n,U,A,t,i){return r(),c("div",p,[e("div",h,[e("button",{onClick:n[0]||(n[0]=(...l)=>i.closeModal&&i.closeModal(...l)),class:"absolute top-2 right-2 text-gray-500 hover:text-gray-700"},_),t.showDetails?(r(),c("div",g,[b,e("div",null,[t.errorMessage?(r(),c("div",v,s(t.errorMessage),1)):d("",!0),e("div",D,[y,e("div",x,[e("p",null,[M,o(" "+s(t.formData.clientCode),1)]),e("p",null,[C,o(" "+s(t.formData.date),1)]),e("p",null,[w,o(" "+s(t.formData.volumeCU),1)]),e("p",null,[k,o(" "+s(t.formData.location),1)]),e("p",null,[j,o(" "+s(t.formData.route),1)]),e("p",null,[S,o(" "+s(t.formData.subcanal),1)]),B,e("p",null,[E,o(" "+s(t.formData.condition),1)]),e("p",null,[N,o(" "+s(t.formData.doorsToNegotiate),1)]),e("p",null,[V,o(" "+s(t.formData.reason),1)]),e("p",null,[P,o(" "+s(t.formData.justification),1)])])]),e("div",L,[e("button",{onClick:n[1]||(n[1]=(...l)=>i.closeModal&&i.closeModal(...l)),class:"text-black hover:underline focus:outline-none rounded-full"},"Cerrar")])])])):d("",!0)])])}const q=u(m,[["render",T]]);export{q as default};