import{d as r,k as v,o as s,c as g,w as _,a as e,i as y,e as o,f as h,t as c,p as b,q as w,s as E}from"./app-DmHcnRqb.js";import{_ as k}from"./AppLayout-Z_cMqC5f.js";import{_ as U}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Banner-BfN-nDuS.js";const i=n=>(b("data-v-31f8d543"),n=n(),w(),n),S=i(()=>e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Upload Excel Document ",-1)),D={class:"py-12"},C={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},A={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-8"},B=i(()=>e("label",{for:"file-upload",class:"block text-sm font-medium text-gray-700"}," Excel document ",-1)),L={class:"mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"},F={class:"space-y-1 text-center"},H={key:0,class:"loader"},N={key:1,class:"text-xs text-gray-500"},T={key:2,class:"text-xs text-green-500"},V={key:3,class:"text-xs text-red-500"},I={key:4,class:"mx-auto h-12 w-12 text-gray-400",stroke:"currentColor",fill:"none",viewBox:"0 0 48 48","aria-hidden":"true"},P=i(()=>e("path",{d:"M28 8H12a4 4 0 00-4 4v24a4 4 0 004 4h16m8-12l-8 8m0 0l-8-8m8 8V12","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"},null,-1)),j=[P],M={class:"flex text-sm text-gray-600"},X={for:"file-upload",class:"relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"},O={key:0},Y=i(()=>e("p",{class:"text-xs text-gray-500"}," XLS, XLSX up to 10MB ",-1)),q=i(()=>e("div",null,[e("button",{type:"submit",class:"inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"}," Upload ")],-1)),$={__name:"Dashboard",setup(n){const a=r(null),t=r(""),f=r(""),d=r(!1),x=l=>{a.value=l.target.files[0],f.value=a.value?a.value.name:"",t.value="File selected"},m=async()=>{if(a.value){d.value=!0,t.value="Uploading...";const l=new FormData;l.append("excel",a.value);try{const p=await E.post("/upload-excel",l,{headers:{"Content-Type":"multipart/form-data"},onUploadProgress:z=>{}});d.value=!1,p.status===200?t.value="THE DATA HAVE BEEN SUCCESSFULLY UPLOADED":t.value="Upload failed"}catch{d.value=!1,t.value="Upload failed"}}},u=v(()=>t.value==="File selected"||d.value);return(l,p)=>(s(),g(k,{title:"Dashboard"},{header:_(()=>[S]),default:_(()=>[e("div",D,[e("div",C,[e("div",A,[e("form",{onSubmit:y(m,["prevent"]),class:"space-y-6"},[e("div",null,[B,e("div",L,[e("div",F,[u.value?(s(),o("span",H)):h("",!0),u.value?(s(),o("p",N,c(t.value)+": "+c(f.value),1)):t.value==="THE DATA HAVE BEEN SUCCESSFULLY UPLOADED"?(s(),o("p",T,c(t.value),1)):t.value==="Upload failed"?(s(),o("p",V,c(t.value),1)):(s(),o("svg",I,j)),e("div",M,[e("label",X,[u.value?h("",!0):(s(),o("span",O,"Upload a file")),e("input",{id:"file-upload",name:"file-upload",type:"file",class:"sr-only",accept:".xlsx, .xls",onChange:x},null,32)])]),Y])])]),q],32)])])])]),_:1}))}},R=U($,[["__scopeId","data-v-31f8d543"]]);export{R as default};