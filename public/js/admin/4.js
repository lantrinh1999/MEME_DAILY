(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{"0rhC":function(t,e,r){"use strict";r.r(e);var n=r("z8rv"),s=r("4ZJI"),o=r("z3DO"),a={metaInfo:{title:"Edit User"},layout:n.a,components:{TextInput:s.a,Btn:o.a},data:function(){var t,e,r,n,s;return{loading:!1,form:{first_name:null!==(t=this.user.first_name)&&void 0!==t?t:null,last_name:null!==(e=this.user.last_name)&&void 0!==e?e:null,email:null!==(r=this.user.email)&&void 0!==r?r:null,username:null!==(n=this.user.username)&&void 0!==n?n:null,password:null,password_confirmation:null,is_super:null!==(s=this.user.is_super)&&void 0!==s?s:null}}},props:{user:Object,pageTitle:String},methods:{submit:function(){var t=this;this.loading=!0,this.$inertia.put(this.route("users.update",this.user.id),this.form).then((function(){setTimeout((function(){t.loading=!1}),500)}))},destroy:function(){confirm("Are you sure you want to delete this?")&&this.$inertia.delete(this.route("users.destroy",this.user.id))},trashed:function(){confirm("Are you sure you want to move to trash this user?")&&this.$inertia.post(this.route("users.trashed"),{id:this.user.id})},restore:function(){confirm("Are you sure you want to restore this organization?")&&this.$inertia.put(this.route("users.restore",this.user.id))}}},i=r("KHd+"),u=Object(i.a)(a,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-9"},[r("div",{staticClass:"card"},[r("div",{staticClass:"card-body"},[r("form",{attrs:{method:"post",id:"user_store",action:t.route("users.store")},on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[r("div",{staticClass:"row"},[r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.first_name,label:"First name"},model:{value:t.form.first_name,callback:function(e){t.$set(t.form,"first_name",e)},expression:"form.first_name"}}),t._v(" "),r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.last_name,label:"Last name"},model:{value:t.form.last_name,callback:function(e){t.$set(t.form,"last_name",e)},expression:"form.last_name"}}),t._v(" "),r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.email,type:"email",label:"Email"},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}}),t._v(" "),r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,disabled:!0,errors:t.$page.errors.username,type:"text",label:"Username"},model:{value:t.form.username,callback:function(e){t.$set(t.form,"username",e)},expression:"form.username"}})],1),t._v(" "),r("div",{staticClass:"row"},[r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.password,type:"password",label:"Password"},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}}),t._v(" "),r("text-input",{staticClass:"col-md-6",attrs:{maxlength:50,errors:t.$page.errors.password_confirmation,type:"password",label:"Confirm Password"},model:{value:t.form.password_confirmation,callback:function(e){t.$set(t.form,"password_confirmation",e)},expression:"form.password_confirmation"}})],1)])])])]),t._v(" "),r("div",{staticClass:"col-md-3"},[r("div",{staticClass:"card"},[t._m(0),t._v(" "),r("div",{staticClass:"card-body"},[r("btn",{staticClass:"btn btn-success",attrs:{loading:t.loading,form:"user_store",name:"Save"}}),t._v(" "),t.user.deleted_at||t.user.id==t.$page.auth.user.id?t._e():r("button",{staticClass:"btn btn-danger",on:{click:t.trashed}},[r("i",{staticClass:"fa fa-trash",attrs:{"aria-hidden":"true"}}),t._v(" Move to Trash\n                    ")]),t._v(" "),t.user.deleted_at?r("button",{staticClass:"btn btn-danger",on:{click:t.restore}},[t._v("Restore")]):t._e()],1)]),t._v(" "),r("div",{staticClass:"card"},[r("div",{staticClass:"card-body"},[r("div",{staticClass:"custom-control custom-checkbox"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.is_super,expression:"form.is_super"}],staticClass:"custom-control-input remember",attrs:{type:"checkbox",name:"remember",id:"custom_checkbox_stacked_unchecked",value:"true",placeholder:"Password"},domProps:{checked:Array.isArray(t.form.is_super)?t._i(t.form.is_super,"true")>-1:t.form.is_super},on:{change:function(e){var r=t.form.is_super,n=e.target,s=!!n.checked;if(Array.isArray(r)){var o=t._i(r,"true");n.checked?o<0&&t.$set(t.form,"is_super",r.concat(["true"])):o>-1&&t.$set(t.form,"is_super",r.slice(0,o).concat(r.slice(o+1)))}else t.$set(t.form,"is_super",s)}}}),t._v(" "),r("label",{staticClass:"custom-control-label",attrs:{for:"custom_checkbox_stacked_unchecked"}},[t._v("\n                            Super administrator")])])])])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header"},[e("h5",[this._v("Actions")])])}],!1,null,null,null);e.default=u.exports},"9tPo":function(t,e){t.exports=function(t){var e="undefined"!=typeof window&&window.location;if(!e)throw new Error("fixUrls requires window.location");if(!t||"string"!=typeof t)return t;var r=e.protocol+"//"+e.host,n=r+e.pathname.replace(/\/[^\/]*$/,"/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,(function(t,e){var s,o=e.trim().replace(/^"(.*)"$/,(function(t,e){return e})).replace(/^'(.*)'$/,(function(t,e){return e}));return/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(o)?t:(s=0===o.indexOf("//")?o:0===o.indexOf("/")?r+o:n+o.replace(/^\.\//,""),"url("+JSON.stringify(s)+")")}))}},I1BE:function(t,e){t.exports=function(t){var e=[];return e.toString=function(){return this.map((function(e){var r=function(t,e){var r=t[1]||"",n=t[3];if(!n)return r;if(e&&"function"==typeof btoa){var s=(a=n,"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(a))))+" */"),o=n.sources.map((function(t){return"/*# sourceURL="+n.sourceRoot+t+" */"}));return[r].concat(o).concat([s]).join("\n")}var a;return[r].join("\n")}(e,t);return e[2]?"@media "+e[2]+"{"+r+"}":r})).join("")},e.i=function(t,r){"string"==typeof t&&(t=[[null,t,""]]);for(var n={},s=0;s<this.length;s++){var o=this[s][0];"number"==typeof o&&(n[o]=!0)}for(s=0;s<t.length;s++){var a=t[s];"number"==typeof a[0]&&n[a[0]]||(r&&!a[2]?a[2]=r:r&&(a[2]="("+a[2]+") and ("+r+")"),e.push(a))}},e}},"KHd+":function(t,e,r){"use strict";function n(t,e,r,n,s,o,a,i){var u,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=r,c._compiled=!0),n&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),a?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},c._ssrRegister=u):s&&(u=i?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),u)if(c.functional){c._injectStyles=u;var l=c.render;c.render=function(t,e){return u.call(e),l(t,e)}}else{var f=c.beforeCreate;c.beforeCreate=f?[].concat(f,u):[u]}return{exports:t,options:c}}r.d(e,"a",(function(){return n}))},"aET+":function(t,e,r){var n,s,o={},a=(n=function(){return window&&document&&document.all&&!window.atob},function(){return void 0===s&&(s=n.apply(this,arguments)),s}),i=function(t,e){return e?e.querySelector(t):document.querySelector(t)},u=function(t){var e={};return function(t,r){if("function"==typeof t)return t();if(void 0===e[t]){var n=i.call(this,t,r);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(t){n=null}e[t]=n}return e[t]}}(),c=null,l=0,f=[],d=r("9tPo");function p(t,e){for(var r=0;r<t.length;r++){var n=t[r],s=o[n.id];if(s){s.refs++;for(var a=0;a<s.parts.length;a++)s.parts[a](n.parts[a]);for(;a<n.parts.length;a++)s.parts.push(y(n.parts[a],e))}else{var i=[];for(a=0;a<n.parts.length;a++)i.push(y(n.parts[a],e));o[n.id]={id:n.id,refs:1,parts:i}}}}function m(t,e){for(var r=[],n={},s=0;s<t.length;s++){var o=t[s],a=e.base?o[0]+e.base:o[0],i={css:o[1],media:o[2],sourceMap:o[3]};n[a]?n[a].parts.push(i):r.push(n[a]={id:a,parts:[i]})}return r}function h(t,e){var r=u(t.insertInto);if(!r)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var n=f[f.length-1];if("top"===t.insertAt)n?n.nextSibling?r.insertBefore(e,n.nextSibling):r.appendChild(e):r.insertBefore(e,r.firstChild),f.push(e);else if("bottom"===t.insertAt)r.appendChild(e);else{if("object"!=typeof t.insertAt||!t.insertAt.before)throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var s=u(t.insertAt.before,r);r.insertBefore(e,s)}}function v(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t);var e=f.indexOf(t);e>=0&&f.splice(e,1)}function b(t){var e=document.createElement("style");if(void 0===t.attrs.type&&(t.attrs.type="text/css"),void 0===t.attrs.nonce){var n=function(){0;return r.nc}();n&&(t.attrs.nonce=n)}return _(e,t.attrs),h(t,e),e}function _(t,e){Object.keys(e).forEach((function(r){t.setAttribute(r,e[r])}))}function y(t,e){var r,n,s,o;if(e.transform&&t.css){if(!(o="function"==typeof e.transform?e.transform(t.css):e.transform.default(t.css)))return function(){};t.css=o}if(e.singleton){var a=l++;r=c||(c=b(e)),n=C.bind(null,r,a,!1),s=C.bind(null,r,a,!0)}else t.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(r=function(t){var e=document.createElement("link");return void 0===t.attrs.type&&(t.attrs.type="text/css"),t.attrs.rel="stylesheet",_(e,t.attrs),h(t,e),e}(e),n=$.bind(null,r,e),s=function(){v(r),r.href&&URL.revokeObjectURL(r.href)}):(r=b(e),n=x.bind(null,r),s=function(){v(r)});return n(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;n(t=e)}else s()}}t.exports=function(t,e){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");(e=e||{}).attrs="object"==typeof e.attrs?e.attrs:{},e.singleton||"boolean"==typeof e.singleton||(e.singleton=a()),e.insertInto||(e.insertInto="head"),e.insertAt||(e.insertAt="bottom");var r=m(t,e);return p(r,e),function(t){for(var n=[],s=0;s<r.length;s++){var a=r[s];(i=o[a.id]).refs--,n.push(i)}t&&p(m(t,e),e);for(s=0;s<n.length;s++){var i;if(0===(i=n[s]).refs){for(var u=0;u<i.parts.length;u++)i.parts[u]();delete o[i.id]}}}};var g,w=(g=[],function(t,e){return g[t]=e,g.filter(Boolean).join("\n")});function C(t,e,r,n){var s=r?"":n.css;if(t.styleSheet)t.styleSheet.cssText=w(e,s);else{var o=document.createTextNode(s),a=t.childNodes;a[e]&&t.removeChild(a[e]),a.length?t.insertBefore(o,a[e]):t.appendChild(o)}}function x(t,e){var r=e.css,n=e.media;if(n&&t.setAttribute("media",n),t.styleSheet)t.styleSheet.cssText=r;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(r))}}function $(t,e,r){var n=r.css,s=r.sourceMap,o=void 0===e.convertToAbsoluteUrls&&s;(e.convertToAbsoluteUrls||o)&&(n=d(n)),s&&(n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(s))))+" */");var a=new Blob([n],{type:"text/css"}),i=t.href;t.href=URL.createObjectURL(a),i&&URL.revokeObjectURL(i)}},z3DO:function(t,e,r){"use strict";var n={inheritAttrs:!1,props:{id:{type:String,default:function(){return"text-input-".concat(this._uid)}},type:{type:String,default:"submit"},form:{type:String,default:"form"},name:{type:String,default:"Submit"},loading:{type:Boolean,default:!1}}},s=r("KHd+"),o=Object(s.a)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("button",{staticClass:"btn",attrs:{disabled:t.loading,type:t.type,id:t.id,form:t.form}},[t.loading?t._e():r("i",{staticClass:"fa fa-save"}),t._v(" "),t.loading?r("i",{staticClass:"fa fa-spinner spinner"}):t._e(),t._v("\n    "+t._s(t.name)+"\n")])}),[],!1,null,null,null);e.a=o.exports}}]);
//# sourceMappingURL=4.js.map?id=d8f4c5969b6b9bcdea1c