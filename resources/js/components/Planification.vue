<template>
  <div>
    <div class="ui form">
      <div class="two fields">
        <div class="three wide field">
          <div class="ui vertical steps m-0">
            <div class="active step" style="padding: 7px 27px">
              <i class="sort amount up icon"></i>
              <div class="content">
                <div class="title">Planification</div>
                <div class="description"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="twelve wide field" style="margin: auto">
          <form
            class="ui form filter_ofs_form"
            id="planif1254879856hyuook5454_form"
            style="margin-bottom: 5px"
          >
            <div class="ui form">
              <div class="four fields">
                <div
                  class="three wide field p-0"
                  style="margin-left: 7px"
                ></div>

                <div class="seven wide field">
                  <div
                    class="inline fields"
                    style="margin: 0; justify-content: center"
                  >
                    <div
                      v-for="statut in statuts"
                      class="field"
                      :key="statut.id"
                    >
                      <a
                        class="ui label"
                        :style="
                          'padding: 5px 15px;width: max-content;background-color:' +
                          statut.color +
                          '!important'
                        "
                      >
                        <div class="ui checkbox">
                          <input
                            @change="loadPlanif"
                            type="checkbox"
                            name="statuts[]"
                            v-model="selected_statuts"
                            :checked="false"
                            :value="statut.id"
                          />
                          <label class="detail">
                            {{ statut.designation }}&nbsp;
                          </label>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- <div class="ui center aligned container" style="margin: 7px">
      <div class="ui mini buttons">
        <button
          class="ui labeled basic blue icon button btn_scroll"
          data-dir="left"
        >
          <i class="left chevron icon"></i>
          En arrière
        </button>
        <button @click="ScrollTo(weekyeartr)" class="ui basic blue button">
          Semaine en cours
        </button>

        <button
          class="ui icon basic blue right labeled button btn_scroll"
          data-dir="right"
        >
          En avant
          <i class="right chevron icon"></i>
        </button>
      </div>
    </div> -->

    <div class="ui center aligned container" style="margin: 7px">
      <i
        title=" En arrière"
        class="large blue chevron circle left icon btn_scroll c-pointer"
        data-dir="left"
      ></i>
      <button
        @click="ScrollTo(weekyeartr)"
        class="ui mini blue button"
        style="padding: 4px 11px; font-size: 15px"
      >
        Semaine en cours
      </button>
      <i
        title="En avant"
        class="large blue chevron circle right icon btn_scroll c-pointer"
        data-dir="right"
      ></i>
    </div>
    <div
      class="ui vertical segment"
      id="suivi_box"
      style="min-height: 250px; padding-top: 0"
    ></div>
  </div>
</template>

<script>
export default {
  props: ["weekyeartr", "statuts"],
  data() {
    return {
      selected_statuts: [],
    };
  },
  mounted() {
    $(".ui.checkbox").checkbox();
    this.loadPlanif();
  },
  methods: {
    loadPlanif: function () {
      ajax_get(
        { statuts: this.selected_statuts },
        "/commande/planif",
        (res) => {
          $("#suivi_box").html(res.sections);
          $("#suivi_box").removeClass("loading");
        },
        (err) => {
          $("#suivi_box").removeClass("loading");
        }
      );
    },
    ScrollTo: function (_to) {
      $(".table-responsive").scrollTo(`#${_to}`);
    },
  },
};
</script>
