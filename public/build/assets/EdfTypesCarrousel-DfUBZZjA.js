import{_ as m}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{o as t,e as i,a as l,F as o,h as r,n as c}from"./app-CvdbmLHO.js";const u={data(){return{images:["/images/edf_1.png","/images/edf_2.png","/images/edf_3.png","/images/edf_4.png"],active:0}},methods:{setActive(e){this.active=e}},mounted(){let e=0;setInterval(()=>{e>this.images.length-1&&(e=0),this.active=e,e++},1e4)}},_={class:"relative slide"},f={class:"carousel-inner relative overflow-hidden w-full"},g=["id"],h=["src"],v={class:"w-100 mt-2"},p={class:"carousel-indicators bottom-0 flex h-10 w-full justify-center items-center md:flex"},w={class:"z-50 flex w-4/12 justify-center"},k=["onClick"];function x(e,y,b,C,a,d){return t(),i("div",_,[l("div",f,[(t(!0),i(o,null,r(a.images,(n,s)=>(t(),i("div",{id:`slide-${s}`,key:s,class:c([`${a.active===s?"active":"left-full"}`,"carousel-item inset-0 relative w-full transform transition-all duration-500 ease-in-out"])},[l("img",{class:"block w-full",src:n,alt:"Slide image"},null,8,h)],10,g))),128))]),l("div",v,[l("div",p,[l("ol",w,[(t(!0),i(o,null,r(a.images,(n,s)=>(t(),i("li",{key:s,class:c(`w-3 h-3 md:w-6 md:h-6 rounded-full cursor-pointer mx-2 ${a.active===s?"bg-red-500 scale-125":"bg-gray-300"}`),onClick:B=>d.setActive(s)},null,10,k))),128))])])])])}const z=m(u,[["render",x]]);export{z as default};