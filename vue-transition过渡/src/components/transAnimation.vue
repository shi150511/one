<template>
    <div id="app">
        <a href="https://cn.vuejs.org/v2/guide/transitions.html">我是transAnimation</a>
        <!-- <tab-a></tab-a>
        <tab-b></tab-b> -->
        <button @click="show = !show">隐藏/显示</button>
        <transition name="fade">
            <p v-show="show">我是过渡动画1</p>
        </transition>
        <transition name="trans">
            <p v-show="show">我是过渡动画2</p>
        </transition>
        <transition name="trans">
            <!-- 过渡动画不能使用相同的标签切换 -->
            <!-- 如果使用相同标签切换，需要加上key -->
            <!-- 如果不加key，是不会调用css样式实现切换，而是直接闪出和消失 -->
            <p v-if="show" key="1">我是过渡3</p>
            <p v-else key=2>我是过渡4</p>
        </transition>
        <!-- 作业，自主官网学习，css动画 自己写一个案例 -->
        <!-- 作业，自助官网学习，css自定义类名，结合animate.css 自己写案例-->
         <transition name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight" >
            <p v-if="show">hello word,I love China</p>
        </transition>

        <!-- 过渡模式mode in-out：新元素先进行过渡，完成之后当前元素过渡离开。
                        out-in：当前元素先进行过渡，完成之后新元素过渡进入。-->
        <!-- 多个组件的过渡 -->
        <button @click="tab">{{thetab}}</button>
        <!-- 分别观察out-in和in-out的区别 -->
        <transition name="trans" mode="out-in">
            <!-- <component :is="view"></component> -->
            <!-- vue2.0提供了一个keep-alive组件用来缓存组件,避免多次加载相应的组件,减少性能消耗  https://blog.csdn.net/m0_38069630/article/details/79136501-->
            <keep-alive>
                <!-- <div :is="view"></div> -->
                <component :is="view"></component>
            </keep-alive>
        </transition>

        <!-- js钩子    可以在属性中声明 JavaScript 钩子  八种钩子-->
        <!-- https://cn.vuejs.org/v2/guide/transitions.html#JavaScript-%E9%92%A9%E5%AD%90 -->
        <!-- 当只用 JavaScript 过渡的时候，在 enter 和 leave 中必须使用 done 进行回调。否则，它们将被同步调用，过渡会立即完成。 -->
        <!-- 推荐对于仅使用 JavaScript 过渡的元素添加 v-bind:css="false"，Vue 会跳过 CSS 的检测。这也可以避免过渡过程中 CSS 的影响。 -->
        <button @click="show = !show">
            Toggle
        </button>
        <transition
            v-on:before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
            :css="false"
        >
            <p v-if="show">
            Demo
            </p>
        </transition>

    </div>
</template>

<script>
import tabA from './TabA'
import tabB from './TabB'
import $ from 'jquery'
import 'animate.css'
import Velocity from '../../assets/velocity'
export default {
    data(){
        return {
            show:true,
            view:tabA,
            thetab:'tabA'
        }
    },
    components:{
        tabA,
        tabB
    },
    methods:{
        tab(){
            if(this.view == tabA){
                this.view = tabB;
                this.thetab = 'tabB';
            }else{
                this.view = tabA;
                this.thetab = 'tabA';
            }
        },
        beforeEnter: function (el) {
            el.style.opacity = 0
            el.style.transformOrigin = 'left'
        },
        enter: function (el, done) {
            Velocity(el, { opacity: 1, fontSize: '1.4em' }, { duration: 300 })
            Velocity(el, { fontSize: '1em' }, { complete: done })
        },
        leave: function (el, done) {
            Velocity(el, { translateX: '15px', rotateZ: '50deg' }, { duration: 600 })
            Velocity(el, { rotateZ: '100deg' }, { loop: 2 })
            Velocity(el, {
                rotateZ: '45deg',
                translateY: '30px',
                translateX: '30px',
                opacity: 0
            }, { complete: done })
        }
    }
}
</script>
<style scoped>
    #app{
        margin-left: 500px;
    }
    /* 
        元素进入过程和离开过程的样式
     */
    .fade-enter-active,.fade-leave-active{
        transition: all 1s ease-out;
    }
    /* 
        当vue 版本低于2.1.8是使用fade-leave-active    
        高于2.1.8时使用fade-leave-to
     */
    .fade-enter,.fade-leave-active{
        opacity:0;
    }

    /* 逗号前后千万不能有空格 */
    .trans-enter-active,.trans-leave-active{
        transition: all 1s ease-out;
    }
    .trans-enter{
        opacity:0;
        transform: translateX(-500px);
    }
    .trans-leave-active{
        opacity:0;
        transform: translateX(500px);
    }


</style>
