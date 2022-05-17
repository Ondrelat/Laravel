"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[822],{9822:(e,t,n)=>{n.r(t),n.d(t,{default:()=>x});var r=n(821),l=n(9038),o=(0,r.createElementVNode)("h1",{class:"text-3xl p-6 text-center"},"Créer un nouvel article",-1),a={class:"mb-6"},c=(0,r.createElementVNode)("label",{class:"block mb-2 uppercase font-bold text-xs text-gray-700",for:"title"}," Titre ",-1),s=["textContent"],u={class:"mb-6"},i=(0,r.createElementVNode)("label",{class:"block mb-2 uppercase font-bold text-xs text-gray-700",for:"content"}," Contenu ",-1),d=["textContent"],m={class:"mb-6"},p=(0,r.createElementVNode)("label",{class:"block mb-2 uppercase font-bold text-xs text-gray-700",for:"image"}," Image ",-1),f={class:"mb-6"},b=["disabled"];const x={setup:function(e){var t=(0,l.cI)({title:"",content:"",image:""}),n=function(){t.post("create")};return function(e,l){var x=(0,r.resolveComponent)("Head");return(0,r.openBlock)(),(0,r.createElementBlock)(r.Fragment,null,[(0,r.createVNode)(x,{title:"Create User"}),o,(0,r.createElementVNode)("form",{onSubmit:l[3]||(l[3]=(0,r.withModifiers)((function(){return(0,r.unref)(n)&&(0,r.unref)(n).apply(void 0,arguments)}),["prevent"])),class:"max-w-md mx-auto mt-8"},[(0,r.createElementVNode)("div",a,[c,(0,r.withDirectives)((0,r.createElementVNode)("input",{"onUpdate:modelValue":l[0]||(l[0]=function(e){return(0,r.unref)(t).title=e}),class:"border border-gray-400 p-2 w-full",type:"text",title:"title",id:"title",required:""},null,512),[[r.vModelText,(0,r.unref)(t).title]]),(0,r.unref)(t).errors.title?((0,r.openBlock)(),(0,r.createElementBlock)("div",{key:0,textContent:(0,r.toDisplayString)((0,r.unref)(t).errors.title),class:"text-red-500 text-xs mt-1"},null,8,s)):(0,r.createCommentVNode)("",!0)]),(0,r.createElementVNode)("div",u,[i,(0,r.withDirectives)((0,r.createElementVNode)("input",{"onUpdate:modelValue":l[1]||(l[1]=function(e){return(0,r.unref)(t).content=e}),class:"border border-gray-400 p-2 w-full",type:"content",name:"content",id:"content",required:""},null,512),[[r.vModelText,(0,r.unref)(t).content]]),(0,r.unref)(t).errors.content?((0,r.openBlock)(),(0,r.createElementBlock)("div",{key:0,textContent:(0,r.toDisplayString)((0,r.unref)(t).errors.content),class:"text-red-500 text-xs mt-1"},null,8,d)):(0,r.createCommentVNode)("",!0)]),(0,r.createElementVNode)("div",m,[p,(0,r.createElementVNode)("input",{type:"file",onInput:l[2]||(l[2]=function(e){return(0,r.unref)(t).image=e.target.files[0]})},null,32)]),(0,r.createElementVNode)("div",f,[(0,r.createElementVNode)("button",{type:"submit",class:"bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500",disabled:(0,r.unref)(t).processing},"Ajouter",8,b)])],32)],64)}}}}}]);