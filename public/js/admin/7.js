(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{"/zF9":function(t,e,s){"use strict";s.r(e);var a=s("uKNl"),i=s("z8rv"),r=s("4ZJI"),n=(s("noZS"),s("d8FT")),l=s.n(n),o=s("DzJC"),c=s.n(o),d=s("EVdn"),h=s.n(d),u=s("Grit"),v={metaInfo:{title:"Users"},layout:i.a,components:{Pagination:a.a,TextInput:r.a},remember:["bin"],data:function(){return{checked:[],check:!1,test:"",bin:{title:"Go to Bin",data:{trashed:"only"}},form:{search:this.filters.search,trashed:this.filters.trashed}}},props:{users:Object,filters:{type:Object,default:null}},mounted:function(){this.footable(),Object(u.a)(document.querySelector("[data-check-all-container]"))},watch:{form:{handler:c()((function(){var t=l()(this.form);this.$inertia.replace(this.route("users.index",Object.keys(t).length?t:{}))}),150),deep:!0}},methods:{footable:function(){h()(".table-toggle").footable()},bulkDestroy:function(){var t=this;0===this.checked.length?alert("Please select at least 1 item!"):confirm("Are you sure you want to delete these items?")&&(console.log(this.checked),this.$inertia.post(this.route("users.destroy"),{id:this.checked},{replace:!0,preserveState:!0,preserveScroll:!0}).then((function(){t.checked=[]})))},bulkMoveToTrash:function(){var t=this;0===this.checked.length?alert("Please select at least 1 item!"):confirm("Are you sure you want to delete these items?")&&this.$inertia.post(this.route("users.trashed"),{id:this.checked},{replace:!0,preserveState:!0,preserveScroll:!0}).then((function(){t.checked=[]}))},bulkRestore:function(){var t=this;0===this.checked.length?alert("Please select at least 1 item!"):confirm("Are you sure you want to restore these items?")&&this.$inertia.post(this.route("users.restore"),{id:this.checked},{replace:!0,preserveState:!0,preserveScroll:!0}).then((function(){t.checked=[]}))},confirmDel:function(t){confirm("Are you sure you want to move to trash this user?")&&this.$inertia.post(this.route("users.trashed"),{id:t},{replace:!0,preserveState:!0,preserveScroll:!0})}}},p=s("KHd+"),m=Object(p.a)(v,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12"},[s("div",{staticClass:"mr-auto d-flex justify-content-start"},[s("div",{staticClass:"mb-2"},[s("inertia-link",{staticClass:"btn btn-info btn-sm",attrs:{href:t.route("memes.create")}},[s("i",{staticClass:"fa fa-plus"}),t._v(" "),s("span",{staticClass:"d-none d-lg-inline"},[t._v("Create New Meme")])])],1)])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12 d-flex"},[s("div",{staticClass:"mr-auto d-flex justify-content-start"},[s("div",{staticClass:"dropdown mr-1"},[s("button",{staticClass:"btn btn-light btn-outline-dark dropdown-toggle",attrs:{type:"button",id:"dropdownMenuButton","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[t._v("\n                                        Bulk actions\n                                    ")]),t._v(" "),s("div",{staticClass:"dropdown-menu",attrs:{"aria-labelledby":"dropdownMenuButton"}},["only"!==t.filters.trashed?s("a",{staticClass:"dropdown-item",on:{click:t.bulkMoveToTrash}},[t._v("Move to Trash")]):t._e(),t._v(" "),"only"===t.filters.trashed?s("a",{staticClass:"dropdown-item",on:{click:t.bulkRestore}},[t._v("Restore")]):t._e(),t._v(" "),"only"===t.filters.trashed?s("a",{staticClass:"dropdown-item",on:{click:t.bulkDestroy}},[t._v("Permanently Delete")]):t._e()])]),t._v(" "),s("div",{staticClass:"filters d-flex"},[s("div",{staticClass:"form-group d-none d-sm-inline-block"},[s("text-input",{attrs:{inputClass:"form-control-sm",maxlength:20,type:"text",placeholder:"Search"},model:{value:t.form.search,callback:function(e){t.$set(t.form,"search",e)},expression:"form.search"}})],1)])]),t._v(" "),s("div",{staticClass:"ml-auto d-flex justify-content-end"},[s("div",{},[s("inertia-link",{staticClass:"btn btn-light",attrs:{method:"get",href:t.route("users.index"),data:"only"==t.filters.trashed?{}:t.bin.data}},[t._v(t._s("only"==t.filters.trashed?"Users List":t.bin.title)+"\n                                    ")])],1)])])])]),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table table-striped table-borderless table-hover table-sm tablesaw tablesaw-stack table-toggle",attrs:{"data-check-all-container":""}},[s("thead",[s("tr",[t._m(0),t._v(" "),s("th",{attrs:{"data-hide":"phone,tablet"}},[s("inertia-link",{attrs:{href:"",method:"get",data:{}}},[t._v("ID\n                                    ")])],1),t._v(" "),s("th",[s("inertia-link",{attrs:{href:"",method:"get",data:{}}},[t._v("Username\n                                    ")])],1),t._v(" "),s("th",{attrs:{"data-hide":"phone"}},[s("inertia-link",{attrs:{href:"",method:"get",data:{}}},[t._v("Email\n                                    ")])],1),t._v(" "),s("th",{attrs:{"data-hide":"phone,tablet"}},[t._v("Role")]),t._v(" "),s("th",{staticClass:"action"},[s("inertia-link",{attrs:{href:"",method:"get",data:{}}},[t._v("Action\n                                    ")])],1)])]),t._v(" "),s("tbody",t._l(t.users.data,(function(e){return t.users.data.length>0?s("tr",[s("td",[s("div",{staticClass:"custom-control custom-checkbox"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.checked,expression:"checked"}],staticClass:"custom-control-input checkall__item",attrs:{"data-check-all-item":"",type:"checkbox",name:"id",id:"user_id_"+e.id,placeholder:"Password"},domProps:{value:e.id,checked:Array.isArray(t.checked)?t._i(t.checked,e.id)>-1:t.checked},on:{change:function(s){var a=t.checked,i=s.target,r=!!i.checked;if(Array.isArray(a)){var n=e.id,l=t._i(a,n);i.checked?l<0&&(t.checked=a.concat([n])):l>-1&&(t.checked=a.slice(0,l).concat(a.slice(l+1)))}else t.checked=r}}}),t._v(" "),s("label",{staticClass:"custom-control-label",attrs:{for:"user_id_"+e.id}})])]),t._v(" "),s("td",[t._v("\n                                    "+t._s(e.id)+"\n\n                                ")]),t._v(" "),s("td",[t._v("\n                                    "+t._s(e.username)+"\n\n                                ")]),t._v(" "),s("td",[t._v("\n                                    "+t._s(e.email)+"\n\n                                ")]),t._v(" "),s("td"),t._v(" "),s("td",["only"!=t.filters.trashed?s("div",[s("inertia-link",{staticClass:"btn btn-warning btn-sm",attrs:{href:t.route("users.edit",e.id),method:"get",data:{}}},[t._v("Edit\n                                        ")]),t._v(" "),s("inertia-link",{staticClass:"btn btn-danger btn-sm",class:{disabled:t.$page.auth.user.id===e.id},attrs:{"preserve-scroll":"","preserve-state":"",href:t.route("users.trashed",e.id),method:"delete",data:{}},on:{click:function(s){return s.preventDefault(),t.confirmDel(e.id)}}},[t._v("Del\n                                        ")])],1):s("div",[s("inertia-link",{staticClass:"btn btn-warning btn-sm",attrs:{"preserve-state":"","preserve-scroll":"",href:t.route("users.restore"),method:"post",data:{id:e.id}}},[t._v("Restore\n                                        ")])],1)])]):t._e()})),0)])]),t._v(" "),s("div",{staticClass:"pagination_ d-flex justify-content-end"},[s("pagination",{staticClass:"ml-auto",attrs:{links:t.users.links}})],1)])])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("th",{attrs:{visible:""}},[e("div",{staticClass:"custom-control custom-checkbox"},[e("input",{staticClass:"custom-control-input checkall__item",attrs:{type:"checkbox","data-check-all":"",id:"checkall__all"}}),this._v(" "),e("label",{staticClass:"custom-control-label",attrs:{for:"checkall__all"}})])])}],!1,null,null,null);e.default=m.exports},"4LhF":function(t,e,s){"use strict";var a=s("ZYYU");s.n(a).a},LsKj:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n@media only screen and (max-width: 767px) {\n.page-item {\n    display: none !important;\n}\n.page-item:first-child,\n  .page-item:last-child {\n    display: block !important;\n}\na.active {\n    pointer-events: none !important;\n}\n}\n",""])},ZYYU:function(t,e,s){var a=s("LsKj");"string"==typeof a&&(a=[[t.i,a,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(a,i);a.locals&&(t.exports=a.locals)},uKNl:function(t,e,s){"use strict";var a={props:{links:Array},mounted:function(){}},i=(s("4LhF"),s("KHd+")),r=Object(i.a)(a,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"mt-2 pt-1"},[s("ul",{staticClass:"pagination-separated justify-content-center twbs-separated pagination pagination-default"},[t._l(t.links,(function(e,a){return[null===e.url?s("li",{key:a,staticClass:"page-item",class:{disabled:null===e.url,prev:"Previous"===e.label}},[s("inertia-link",{staticClass:"page-link",attrs:{"preserve-scroll":"",href:e.url||""}},[t._v(t._s(e.label))])],1):s("li",{key:a,staticClass:"page-item",class:{active:e.active,next:"Next"===e.label}},[s("inertia-link",{staticClass:"page-link",class:{active:e.active},attrs:{"preserve-scroll":"",href:e.url||""}},[t._v(t._s(e.label))])],1)]}))],2)])}),[],!1,null,null,null);e.a=r.exports}}]);
//# sourceMappingURL=7.js.map?id=8432a89b737c090a15fe