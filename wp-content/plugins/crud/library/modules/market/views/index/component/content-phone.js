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
        <div class="phone"></div>
    </div>
</div>`,
  data(){
    return {
      phones: [
        {name: "iPhone SE", width: 375, height: 667},
        {name: "iPhone XR", width: 414, height: 896},
        {name: "iPhone 12 Pro", width: 390, height: 844}
      ]
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
  }
});