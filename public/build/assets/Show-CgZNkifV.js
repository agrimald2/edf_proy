import{_ as c}from"./AppLayout-CbtUhwo9.js";import p from"./DeleteUserForm-Av3ZYkYj.js";import l from"./LogoutOtherBrowserSessionsForm-C_gR46jf.js";import{S as s}from"./SectionBorder-rVDd2cZt.js";import f from"./TwoFactorAuthenticationForm-BzX3z-pt.js";import u from"./UpdatePasswordForm-BaU3SYOh.js";import _ from"./UpdateProfileInformationForm-DjfT0vAo.js";import{o,c as d,w as n,a as i,e as r,b as t,f as a,F as h}from"./app-gvrlcMYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Banner-4pa1B5K0.js";import"./DialogModal-Bh4DFOUV.js";import"./SectionTitle-C4_eE4E_.js";import"./DangerButton-BezORXk8.js";import"./TextInput-COm6mnU5.js";import"./SecondaryButton-D0mOcSlO.js";import"./ActionMessage-BWlT9B9R.js";import"./PrimaryButton-CA7kDfrJ.js";import"./InputLabel-BtYROENS.js";import"./FormSection-BJEtIrog.js";const g=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),$={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},w={key:0},k={key:1},y={key:2},G={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(e,x)=>(o(),d(c,{title:"Profile"},{header:n(()=>[g]),default:n(()=>[i("div",null,[i("div",$,[e.$page.props.jetstream.canUpdateProfileInformation?(o(),r("div",w,[t(_,{user:e.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),e.$page.props.jetstream.canUpdatePassword?(o(),r("div",k,[t(u,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),e.$page.props.jetstream.canManageTwoFactorAuthentication?(o(),r("div",y,[t(f,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(l,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),e.$page.props.jetstream.hasAccountDeletionFeatures?(o(),r(h,{key:3},[t(s),t(p,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{G as default};