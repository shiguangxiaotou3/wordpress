// 手机视图
Vue.component("content-phone", {
  template: `
<div class="content-phone">
    <div class="phone-size">
        <select id="phone-size" name="phone-size" @change="phoneSize">
            <option
                v-for="(item,index) in phones"
                :value="index"
                :key="index"
            >{{item.name}}</option>
        </select>
    </div>
    <div class="phone-background-image">
        <div class="phone" 
         @dragover.prevent
        @dragenter="dragenter" 
        @drop="drop" 
        ref="content"></div>
    </div>
</div>`,
  data(){
    return {
      phones: [
        {name: "iPhone SE", width: 375, height: 667},
        {name: "iPhone XR", width: 414, height: 896},
        {name: "iPhone 12 Pro", width: 390, height: 844}
      ],
      options:''
    }
  },
  pros:[],
  mounted() {
    this.phoneSize();
  },
  methods:{
    phoneSize() {
      let index = $("#phone-size").val();
      this.phonesIndex = index;
      $(".phone").width(this.phones[index].width + "px");
      $(".phone").height(this.phones[index].height + "px");
      let w = (this.phones[index].width / 433) * 489;
      let h = (this.phones[index].height / 800) * 922 - 21
      $(".phone-background-image").css({
        "background-size": w + "px " + h + "px",
        "padding-top": (this.phones[index].height / (800 / 60)) + "px",
        "padding-right": (this.phones[index].width / (433 / 28)) + "px",
        "padding-left": (this.phones[index].width / (433 / 28)) + "px",
        "padding-bottom": (this.phones[index].height / (800 / 35)) + "px",
      });
    },
    // dragover(event){
    //   event.dataTransfer.setData('text/plain', 'data-to-transfer');
    // },
    dragenter(e){
      console.log('子 进入')
      let vm = this.$emit('dragenter')
      this.options =vm.options
      console.log(vm.options)
    },
    drop(event){
      console.log('放下')
      console.log(this.$refs.content)
      event.preventDefault();
      const el = new Vue({
        render: h => h(this.options.tag, {
          attrs: this.options.tag,
          on: {}
        }, '这是一个测试元素')
      });
      el.$mount();
      this.$refs.content.appendChild(el.$el);
    }
  }
});