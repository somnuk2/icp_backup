<template>
  <div class="container">
    <article>
      <header>
        <div class="progress">
          <div
            class="progress-step"
            :class="{ active: index === activeStep }"
            v-for="(step, index) in formSteps"
            :key="'step' + index"
          >
            {{ index + 1 }}
          </div>
        </div>
      </header>
      <section :class="animation">
        <h2>{{ formSteps[activeStep].title }}</h2>
        <div class="input-fields">
          <div
            class="input-container"
            v-for="(field, index) in formSteps[activeStep].fields"
            :key="'field' + index"
          >
            <div class="row">
              <div class="col-md-10 col-xs-12 q-pa-md">
                <label class="input-label">{{ field.label }}</label>
              </div>
              <div class="col-md-2 col-xs-12 q-pa-md">
                <input
                  type="checkbox"
                  :checked="checked"
                  :class="{ 'wrong-input': !field.valid }"
                  v-model="field.value"
                  required
                />
              </div>
            </div>
          </div>
        </div>
        <div class="actions">
          <button
            v-if="activeStep + 1 < formSteps.length - 1"
            @click="checkFields"
          >
            next
          </button>
          <button
            v-if="activeStep + 1 === formSteps.length - 1"
            @click="checkFields"
          >
            done
          </button>
        </div>
        <div>
          <q-btn
            color="primary"
            no-caps
            flat
            icon="skip_previous"
            @click="onPrevious"
          />
          <q-btn
            color="primary"
            no-caps
            flat
            icon="skip_next"
            @click="onNext"
          />
        </div>
      </section>
    </article>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      activeStep: 0,
      animation: "animate-in",
      formSteps: [
        {
          title: "ข้อมูลส่วนตัว",
          fields: [
            {
              label: "1.กำหนดชื่อ-สกุล",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "2.กำหนดชั้นปีที่กำลังศึกษา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "3.กำหนดปีที่สำเร็จการศึกษา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "4.กำหนดระดับการศึกษา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "5.กำหนดสาขาวิชา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "6.กำหนดสถาบันการศึกษา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "7.กำหนดสถานะความพิการ",
              value: "",
              valid: true,
              pattern: /.+/,
            },
          ],
        },
        {
          title: "ข้อมูลอาชีพ",
          fields: [
            {
              label: "กำหนดอาชีพเป้าหมาย",
              value: "",
              valid: true,
              pattern: /.+/,
            },
          ],
        },
        {
          title: "ข้อมูลคุณสมบัติ/ทักษะ",
          fields: [
            {
              label: "กำหนดคุณสมบัติแต่ละอาชีพ",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "กำหนดระดับการพัฒนา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "กำหนดเป้าหมายการพัฒนา",
              value: "",
              valid: true,
              pattern: /.+/,
            },
          ],
        },
        {
          title: "ข้อมูลแผนการพัฒนาตนเอง",
          fields: [
            {
              label: "แผนการเรียนรู้ภาคทฤษฏี",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "แผนการเรียนรู้ภาคปฏิบัติ",
              value: "",
              valid: true,
              pattern: /.+/,
            },
          ],
        },
        {
          title: "ข้อมูลการประเมินการพัฒนาตนเอง",
          fields: [
            {
              label: "ประเมินตนเอง เดือนมกราคม",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "ประเมินตนเอง เดือนเมษายน",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "ประเมินตนเอง เดือนกรกฏาคม",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "ประเมินตนเอง เดือนตุลาคม",
              value: "",
              valid: true,
              pattern: /.+/,
            },
            {
              label: "ประเมินตนเอง เดือนธันวาคม",
              value: "",
              valid: true,
              pattern: /.+/,
            },
          ],
        },
        {
          title: "ขอบคุณสำหรับการรายงานความก้าวหน้า",
        },
      ],
    };
  },
  methods: {
    nextStep() {
      this.animation = "animate-out";
      setTimeout(() => {
        this.animation = "animate-in";
        this.activeStep += 1;
      }, 550);
    },
    checkFields() {
      let valid = true;
      this.formSteps[this.activeStep].fields.forEach((field) => {
        if (!field.pattern.test(field.value)) {
          valid = false;
          field.valid = false;
        } else {
          field.valid = true;
        }
      });
      if (valid) {
        this.nextStep();
      } else {
        this.animation = "animate-wrong";
        setTimeout(() => {
          this.animation = "";
        }, 400);
      }
    },
    onNext() {},
    onPrevious() {
      this.$router.replace({ name: "FormPivotTable" });
    },
  },
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans&display=swap");
@mixin flexbox() {
  display: flex;
  justify-content: center;
  align-items: center;
}
.container {
  @include flexbox();
  width: 100%;
  min-height: 100vh;
  font-family: "Noto Sans", sans-serif;
  background: radial-gradient(#df5c2e, #a43227);
}
article {
  display: flex;
  margin: 10px;
  width: calc(100% - 20px);
  max-width: 720px;
  min-height: 480px;
  perspective: 1000px;
  header {
    @include flexbox();
    width: 60px;
    height: 480px;
    background-color: #fff;
    border-right: 2px dotted #df5c2e;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 10px 10px rgba(0, 0, 0, 0.2);
  }
  .progress-step {
    @include flexbox();
    position: relative;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-bottom: 20px;
    color: #fff;
    background-color: #df5c2e;
    font-weight: bold;
    &.active {
      background-color: #df5c2e;
      ~ .progress-step {
        color: #555;
        background-color: #ccc;
      }
      ~ .progress-step::before {
        background-color: #ccc;
      }
    }
    &:before {
      content: "";
      position: absolute;
      top: -20px;
      width: 2px;
      height: 20px;
      background-color: #df5c2e;
      z-index: 10;
    }
    &:first-child::before {
      display: none;
    }
  }
  section {
    @include flexbox();
    flex-direction: column;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 10px 10px rgba(0, 0, 0, 0.2);
    h2 {
      font-size: 1.6rem;
      color: #df5c2e;
      margin: 0;
      padding: 20px;
    }
    .input-fields {
      @include flexbox();
      flex-direction: column;
      width: 100%;
    }
    .input-container {
      position: relative;
      padding: 30px 20px 20px 20px;
      width: calc(100% - 40px);
      max-width: 400px;
      input {
        position: relative;
        width: 100%;
        font-family: "Noto Sans", sans-serif;
        font-size: 1.35rem;
        outline: none;
        background: transparent;
        box-shadow: none;
        border: none;
        border-bottom: 2px dashed #df5c2e;
        &:valid + .input-label {
          top: 10px;
          left: 20px;
          font-size: 0.7rem;
          font-weight: normal;
          color: #999;
        }
        &.wrong-input + .input-label {
          color: #b92938;
        }
      }
    }
    .input-label {
      position: absolute;
      top: 32px;
      left: 20px;
      font-size: 1.35rem;
      pointer-events: none;
      transition: 0.2s ease-in-out;
    }
    .actions {
      margin: 0;
      button {
        font-family: "Noto Sans", sans-serif;
        outline: none;
        border: none;
        color: #fff;
        background-color: #df5c2e;
        font-size: 1.35rem;
        padding: 5px 20px;
        margin: 0;
        text-transform: uppercase;
        border-radius: 3px;
        cursor: pointer;
      }
    }
  }
}
.animate-in {
  transform-origin: left;
  animation: in 0.6s ease-in-out;
}
.animate-out {
  transform-origin: bottom left;
  animation: out 0.6s ease-in-out;
}
.animate-wrong {
  animation: wrong 0.4s ease-in-out;
}
@keyframes in {
  0% {
    opacity: 0;
    transform: rotateY(90deg);
  }
  100% {
    opacity: 1;
    transform: rotateY(0deg);
  }
}
@keyframes out {
  0% {
    transform: translateY(0px) rotate(0deg);
  }
  60% {
    transform: rotate(10deg);
  }
  100% {
    transform: translateY(1000px);
  }
}
@keyframes wrong {
  0% {
    transform: translateX(0);
  }
  20% {
    transform: translateX(40px);
  }
  40% {
    transform: translateX(20px);
  }
  60% {
    transform: translateX(40px);
  }
  80% {
    transform: translateX(20px);
  }
  100% {
    transform: translateX(0);
  }
}
</style>
