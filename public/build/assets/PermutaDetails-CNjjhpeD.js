import{_ as d}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{o as i,e as r,a as e,t as s,f as c}from"./app-DbDUQngT.js";const u={props:{show:{type:Boolean,default:!1},permuta:{type:Object,required:!0},haveAvailableLimit:{type:Boolean,default:!0},sv:{type:String}},data(){return{formData:{clientCode:this.permuta.cod_cliente,volumeCU:this.permuta.volume,location:this.permuta.location.name,route:this.permuta.route,subcanal:this.permuta.subcanal,haveEdf:this.permuta.have_edf,doorsToNegotiate:this.permuta.doors_to_negotiate,condition:this.permuta.condition,reason:this.permuta.reason,justification:this.permuta.justification},reasons:[],sentPermutaViewModal:!1,errorMessage:"",isSubmitting:!1,showDetails:!0}},mounted(){fetch("/api/permuta-reasons").then(o=>o.json()).then(o=>{this.reasons=o}).catch(o=>{console.error("Error fetching reasons:",o)})},methods:{detailsModal(){console.log("A"),this.showDetails=!0},closeModal(){this.$emit("close"),this.detailsModal()}}},m={class:"z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4"},p={class:"bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative"},h=e("i",{class:"fa-solid fa-circle-xmark text-gray-500"},null,-1),_=[h],f={key:0},g=e("div",{class:"text-center mb-6"},[e("h2",{class:"text-2xl font-bold"},"Detalles de Permuta"),e("p",{class:"text-gray-600"},"Revisa la información de la permuta")],-1),v={key:0,class:"text-red-500 text-center mb-4"},b={class:"space-y-4"},x={class:"bg-gray-100 p-4 rounded-lg"},y=e("h3",{class:"font-bold mb-2 text-red-700"},"Información del cliente",-1),D={class:"grid grid-cols-2 gap-4"},M=e("p",null,[e("span",{class:"font-medium"},"Código de cliente:")],-1),C=e("p",null,[e("span",{class:"font-medium"},"Volumen en CU:")],-1),w=e("p",null,[e("span",{class:"font-medium"},"Locación:")],-1),k=e("p",null,[e("span",{class:"font-medium"},"Ruta:")],-1),j=e("p",null,[e("span",{class:"font-medium"},"Subcanal:")],-1),B={class:"bg-gray-100 p-4 rounded-lg"},E=e("h3",{class:"font-bold mb-2 text-red-700"},"EDF a solicitar",-1),N={class:"grid grid-cols-2 gap-4"},P=e("p",null,[e("span",{class:"font-medium"},"Condición:")],-1),S=e("p",null,[e("span",{class:"font-medium"},"Puertas a negociar:")],-1),V=e("p",null,[e("span",{class:"font-medium"},"Motivo:")],-1),U=e("p",null,[e("span",{class:"font-medium"},"Justificación:")],-1),A={class:"mt-6 text-center"};function L(o,a,R,T,t,l){return i(),r("div",m,[e("div",p,[e("button",{onClick:a[0]||(a[0]=(...n)=>l.closeModal&&l.closeModal(...n)),class:"absolute top-2 right-2 text-gray-500 hover:text-gray-700"},_),t.showDetails?(i(),r("div",f,[g,e("div",null,[t.errorMessage?(i(),r("div",v,s(t.errorMessage),1)):c("",!0),e("div",b,[e("div",x,[y,e("div",D,[M,e("p",null,s(t.formData.clientCode),1),C,e("p",null,s(t.formData.volumeCU),1),w,e("p",null,s(t.formData.location),1),k,e("p",null,s(t.formData.route),1),j,e("p",null,s(t.formData.subcanal),1)])]),e("div",B,[E,e("div",N,[P,e("p",null,s(t.formData.condition),1),S,e("p",null,s(t.formData.doorsToNegotiate),1),V,e("p",null,s(t.formData.reason),1),U,e("p",null,s(t.formData.justification),1)])])]),e("div",A,[e("button",{onClick:a[1]||(a[1]=(...n)=>l.closeModal&&l.closeModal(...n)),class:"bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none"},"Cerrar")])])])):c("",!0)])])}const F=d(u,[["render",L]]);export{F as default};