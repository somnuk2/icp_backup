<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          รหัส :
          <label for="member_id">{{ $store.getters.myMember_id }}</label>
          /
          <label for="myName">{{ $store.getters.myName }}</label>
        </q-toolbar-title>
        <div>
          <q-toolbar-title shrink class="text-weight-bold">
            <q-btn
              v-if="!$store.getters.myAuthenticate"
              flat
              round
              dense
              icon="login"
              @click="onLogin"
              ><q-tooltip :target="true"> เข้าสู่ระบบ </q-tooltip>
            </q-btn>
            <q-btn
              v-if="$store.getters.myAuthenticate"
              flat
              round
              dense
              icon="logout"
              @click="onLogout"
            >
              <q-tooltip :target="true"> ออกจากระบบ </q-tooltip>
            </q-btn>
          </q-toolbar-title>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header> ICP SCORE CARD </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from "vue";
import EssentialLink from "components/EssentialLink.vue";

const linksList = [
  {
    title: "กำหนดข้อมูลส่วนตัว",
    caption: "การศึกษา ความพิการ",
    icon: "lock_outline",
    link: "/FormComponent",
  },
  {
    title: "กำหนดอาชีพเป้าหมาย",
    caption: "อาชีพในอนาคต",
    icon: "work_history",
    link: "/FormPlanCareer",
  },
  {
    title: "กำหนดคุณสมบัติ/ทักษะ",
    caption: "คุณสมบัติและทักษะ เป้าหมาย ระดับ",
    icon: "fact_check",
    link: "/FormQualification",
  },
  {
    title: "การพัฒนาตนเอง",
    caption: "ศึกษาเรียนรู้ ฝึกปฏิบัติ",
    icon: "post_add",
    link: "/FormPlan",
  },
  {
    title: "การประเมินตนเอง",
    caption: "เดือน ระดับ",
    icon: "checklist_rtl",
    link: "/FormSelfAssessment",
  },
  {
    title: "รายงานแผนการพัฒนาตนเอง",
    caption: "ผลการพัฒนาตนเอง",
    icon: "summarize",
    link: "/FormReport",
  },
  {
    title: "รายงานการประเมินตนเอง",
    caption: "ผลการประเมินตนเอง",
    icon: "summarize",
    link: "/FormPivotTable",
  },
];

export default defineComponent({
  name: "MainLayout",

  components: {
    EssentialLink,
  },
  methods: {
    onLogin() {
      this.$router.replace({ name: "LoginPage1" });
    },
    onLogout() {
      this.$router.replace({ name: "LogoutPage" });
    },
  },
  setup() {
    const leftDrawerOpen = ref(false);

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },
});
</script>
