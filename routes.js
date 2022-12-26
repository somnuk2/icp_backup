import FormComponent from "pages/forms/FormComponent.vue";
import FormPivotTable from "pages/forms/FormPivotTable.vue";
import FormPlan from "pages/forms/FormPlan.vue";
import FormPlanCareer from "pages/forms/FormPlanCareer.vue";
import FormQualification from "pages/forms/FormQualification.vue";
import FormSelfAssessment from "pages/forms/FormSelfAssessment.vue";
import FormReport from "pages/forms/FormReport.vue";
import FormRegistration from "pages/forms/FormRegistration.vue";
import LoginPage1 from "pages/registration/LoginPage1.vue";
import LogoutPage from "pages/registration/LogoutPage.vue";
import RegistrationPage from "pages/registration/RegistrationPage.vue";
import MainLayout from "layouts/MainLayout.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: MainLayout,
    children: [{ path: "/", component: () => import("pages/IndexPage.vue") }],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
  {
    path: "/FormRegistration",
    name: "FormRegistration",
    component: FormRegistration,
  },
  {
    path: "/FormComponent",
    name: "FormComponent",
    component: FormComponent,
  },
  {
    path: "/FormPivotTable",
    name: "FormPivotTable",
    component: FormPivotTable,
  },
  {
    path: "/FormReport",
    name: "FormReport",
    component: FormReport,
  },
  {
    path: "/FormPlan",
    name: "FormPlan",
    component: FormPlan,
  },
  {
    path: "/FormPlanCareer",
    name: "FormPlanCareer",
    component: FormPlanCareer,
  },
  {
    path: "/FormQualification",
    name: "FormQualification",
    component: FormQualification,
  },
  {
    path: "/FormSelfAssessment",
    name: "FormSelfAssessment",
    component: FormSelfAssessment,
  },
  {
    path: "/LoginPage1",
    name: "LoginPage1",
    component: LoginPage1,
  },
  {
    path: "/LogoutPage",
    name: "LogoutPage",
    component: LogoutPage,
  },
  {
    path: "/RegistrationPage",
    name: "RegistrationPage",
    component: RegistrationPage,
  },
];

export default routes;
