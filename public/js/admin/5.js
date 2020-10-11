/*! For license information please see 5.js.LICENSE.txt?id=036063618c8eed0faef5 */
(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{JHgf:function(t,e,n){(e=t.exports=n("I1BE")(!1)).push([t.i,"@import url(https://fonts.googleapis.com/css?family=Roboto:400,500);",""]),e.push([t.i,"\n/*!Don't remove this!\r\n * Material-Toast plugin styles\r\n * \r\n * Author: Dionlee Uy\r\n * Email: dionleeuy@gmail.com\r\n */\n.mdtoast {\n  position: fixed;\n  display: flex;\n  flex-direction: row;\n  align-items: center;\n  justify-content: flex-start;\n  box-sizing: border-box;\n  left: 24px;\n  bottom: 24px;\n  padding: 0 24px;\n  color: #fff;\n  font-family: Roboto, sans-serif;\n  font-size: 16px;\n  text-align: left;\n  outline: none;\n  pointer-events: auto;\n  touch-action: auto;\n  -webkit-user-select: none;\n     -moz-user-select: none;\n      -ms-user-select: none;\n          user-select: none;\n  background-color: #323232;\n  transform: translateY(0);\n  transition: transform 0.23s 0ms cubic-bezier(0, 0, 0.2, 1);\n  will-change: transform;\n  z-index: 100002;\n}\n@media (min-width: 600px) {\n  .mdtoast {\n    min-width: 288px;\n    max-width: 568px;\n    border-radius: 4px;\n  }\n}\n@media (max-width: 599px) {\n  .mdtoast {\n    left: 0;\n    bottom: 0;\n    right: 0;\n    font-size: 14px;\n    max-width: 100%;\n    transform: translateY(0);\n  }\n}\n",""])},"KHd+":function(t,e,n){"use strict";function o(t,e,n,o,s,a,i,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),o&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),i?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},c._ssrRegister=l):s&&(l=r?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(c.functional){c._injectStyles=l;var m=c.render;c.render=function(t,e){return l.call(e),m(t,e)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:t,options:c}}n.d(e,"a",(function(){return o}))},a16U:function(t,e,n){"use strict";n.r(e);var o=n("z8rv"),s=n("4ZJI"),a=n("z3DO"),i=n("EVdn"),r=n.n(i),l={metaInfo:{title:"Create User"},layout:o.a,components:{TextInput:s.a,Btn:a.a},data:function(){return{loading:!1,form:{first_name:"",last_name:"",email:"",username:"",password:"",password_confirmation:"",is_super:!1}}},props:{pageTitle:String},methods:{submit:function(){var t=this;this.loading=!0,this.$inertia.post(this.route("users.store"),this.form).then((function(){t.$page.flash.success&&(t.form={first_name:"",last_name:"",email:"",username:"",password:"",password_confirmation:"",is_super:!1}),setTimeout((function(){t.loading=!1}),500)}))}},mounted:function(){r()(document).ready((function(){r()("#mytags").tagit({singleField:!0,singleFieldNode:r()("#mySingleField"),allowSpaces:!0,minLength:2,removeConfirmation:!0,tagSource:function(t,e){r.a.ajax({url:"search.php",data:{term:t.term},dataType:"json",success:function(t){e(r.a.map(t,(function(t){return{label:t.label+" ("+t.id+")",value:t.value}})))}})}})}))}},c=n("KHd+"),m=Object(c.a)(l,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-9"},[n("div",{staticClass:"card"},[n("div",{staticClass:"card-body"},[n("form",{attrs:{method:"post",id:"user_store",action:t.route("users.store"),autocomplete:"off"},on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[n("div",{staticClass:"row"},[n("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.first_name,label:"First name"},model:{value:t.form.first_name,callback:function(e){t.$set(t.form,"first_name",e)},expression:"form.first_name"}}),t._v(" "),n("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.last_name,label:"Last name"},model:{value:t.form.last_name,callback:function(e){t.$set(t.form,"last_name",e)},expression:"form.last_name"}}),t._v(" "),n("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.email,type:"email",label:"Email"},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}}),t._v(" "),n("text-input",{staticClass:"col-md-6",attrs:{errors:t.$page.errors.username,type:"text",label:"Username"},model:{value:t.form.username,callback:function(e){t.$set(t.form,"username",e)},expression:"form.username"}})],1),t._v(" "),n("div",{staticClass:"row"},[n("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.password,type:"password",label:"Password"},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}}),t._v(" "),n("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.password_confirmation,type:"password",label:"Confirm Password"},model:{value:t.form.password_confirmation,callback:function(e){t.$set(t.form,"password_confirmation",e)},expression:"form.password_confirmation"}})],1)])])])]),t._v(" "),n("div",{staticClass:"col-md-3"},[n("div",{staticClass:"card"},[n("div",{staticClass:"card-body"},[n("btn",{staticClass:"btn btn-success",attrs:{loading:t.loading,form:"user_store",name:"Save"}})],1)]),t._v(" "),n("div",{staticClass:"card"},[n("div",{staticClass:"card-body"},[n("div",{staticClass:"custom-control custom-checkbox"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.is_super,expression:"form.is_super"}],staticClass:"custom-control-input remember",attrs:{type:"checkbox",name:"remember",id:"custom_checkbox_stacked_unchecked",value:"true",placeholder:"Password"},domProps:{checked:Array.isArray(t.form.is_super)?t._i(t.form.is_super,"true")>-1:t.form.is_super},on:{change:function(e){var n=t.form.is_super,o=e.target,s=!!o.checked;if(Array.isArray(n)){var a=t._i(n,"true");o.checked?a<0&&t.$set(t.form,"is_super",n.concat(["true"])):a>-1&&t.$set(t.form,"is_super",n.slice(0,a).concat(n.slice(a+1)))}else t.$set(t.form,"is_super",s)}}}),t._v(" "),n("label",{staticClass:"custom-control-label",attrs:{for:"custom_checkbox_stacked_unchecked"}},[t._v("\n                            Super administrator")])])])])])])])}),[],!1,null,null,null);e.default=m.exports},"l5/N":function(t,e,n){var o=n("JHgf");"string"==typeof o&&(o=[[t.i,o,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(o,s);o.locals&&(t.exports=o.locals)},tGQw:function(t,e,n){t.exports=function(){"use strict";function t(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function e(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}var n={init:!1,duration:5e3,type:"default",modal:!1,interaction:!1,interactionTimeout:null,actionText:"OK",action:function(){this.hide()},callbacks:{}},o="mdtoast--open",s="mdtoast--modal";function a(){var t={},e=!1,n=0,o=arguments.length;"[object Boolean]"===Object.prototype.toString.call(arguments[0])&&(e=arguments[0],n++);for(var s=function(n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e&&"[object Object]"===Object.prototype.toString.call(n[o])?t[o]=a(!0,t[o],n[o]):t[o]=n[o])};n<o;n++){var i=arguments[n];s(i)}return t}function i(t,e,n,o){var s=document.createElement(t);return s.className=e,void 0!==n&&(s[o?"innerHTML":"innerText"]=n),s}function r(){var t,e,n=this,o=n.options,s=function(t){t.target.matches(".mdt-action")&&("click"===t.type||"keypress"===t.type&&13===t.keyCode)&&o.action&&o.action.call(n,t)};n.docFrag=document.createDocumentFragment(),n.toast=i("div","mdtoast mdt--load"),n.toast.tabIndex=0,n.docFrag.appendChild(n.toast),"default"!==o.type&&n.toast.classList.add("mdt--"+o.type),t=i("div","mdt-message",n.message,!0),n.toast.appendChild(t),e=i("span","mdt-action"),o.interaction&&(e.innerText=o.actionText,e.tabIndex=0,n.toast.classList.add("mdt--interactive"),n.toast.appendChild(e)),n.toast.addEventListener("click",s,!1),n.toast.addEventListener("keypress",s,!1),n.toast.mdtoast=n,n.options.init||n.show()}function l(t){var e=this,n=document.body,a=e.options.callbacks;n.appendChild(e.docFrag),setTimeout((function(){e.toast.classList.remove("mdt--load"),setTimeout((function(){a&&a.shown&&a.shown.call(e),t&&"function"==typeof t&&t.call(e)}),e.animateTime),e.options.interaction?e.options.interactionTimeout&&(e.timeout=setTimeout((function(){e.hide()}),e.options.interactionTimeout)):e.options.duration&&(e.timeout=setTimeout((function(){e.hide()}),e.options.duration)),n.classList.add(o),e.options.modal&&n.classList.add(s)}),15)}var c=function(){function i(e,o){t(this,i);var s=arguments;this.animateTime=230,this.message=s[0],this.options=a(!0,n,s[1]),this.timeout=null,this.options.init||r.call(this)}var c,m,d;return c=i,(m=[{key:"show",value:function(t){var e=this,n=document.getElementsByClassName("mdtoast");if(!document.body.contains(e.toast))if(e.options.init&&r.apply(e),n.length>0)for(var o=n.length-1;o>=0;o--)n[o].mdtoast.hide((function(){o<0&&l.call(e,t)}));else l.call(e,t)}},{key:"hide",value:function(t){var e=this,n=e.options.callbacks,a=document.body;clearTimeout(e.timeout),e.toast.classList.add("mdt--load"),a.classList.remove(o),a.classList.remove(s),setTimeout((function(){a.removeChild(e.toast),n&&n.hidden&&n.hidden.call(e),t&&"function"==typeof t&&t.call(e)}),e.animateTime)}}])&&e(c.prototype,m),d&&e(c,d),i}();function m(t,e){return e||(e={}),new c(t,e)}return Object.defineProperties(m,{INFO:{value:"info"},ERROR:{value:"error"},WARNING:{value:"warning"},SUCCESS:{value:"success"}}),Element.prototype.matches||(Element.prototype.matches=Element.prototype.matchesSelector||Element.prototype.mozMatchesSelector||Element.prototype.msMatchesSelector||Element.prototype.oMatchesSelector||Element.prototype.webkitMatchesSelector||function(t){for(var e=(this.document||this.ownerDocument).querySelectorAll(t),n=e.length;--n>=0&&e.item(n)!==this;);return n>-1}),m}()},z3DO:function(t,e,n){"use strict";var o={inheritAttrs:!1,props:{id:{type:String,default:function(){return"text-input-".concat(this._uid)}},type:{type:String,default:"submit"},form:{type:String,default:"form"},name:{type:String,default:"Submit"},loading:{type:Boolean,default:!1}}},s=n("KHd+"),a=Object(s.a)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("button",{staticClass:"btn",attrs:{disabled:t.loading,type:t.type,id:t.id,form:t.form}},[t.loading?t._e():n("i",{staticClass:"fa fa-save"}),t._v(" "),t.loading?n("i",{staticClass:"fa fa-spinner spinner"}):t._e(),t._v("\n    "+t._s(t.name)+"\n")])}),[],!1,null,null,null);e.a=a.exports}}]);
//# sourceMappingURL=5.js.map?id=036063618c8eed0faef5