"use strict";var Observable=function(){var s=this;return s.data,s.subs=[],s.methods={publish:function(u){if(void 0===u)return s.data;s.data=u;for(var e=0,i=s.subs.length;e<i;++e)s.subs[e](s.data)},subscribe:function(u){-1===s.subs.indexOf(u)&&s.subs.push(u)},unsubscribe:function(u){-1!==s.subs.indexOf(u)&&s.subs.splice(s.subs.indexOf(u),1)}},s.methods},view={},model={};