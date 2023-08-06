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

        <div class="fourteen wide field" style="margin: auto">
          <form
            class="ui form filter_ofs_form"
            id="planif1254879856hyuook5454_form"
            style="margin-bottom: 5px"
          >
            <div class="ui form">
              <div class="four fields">
                <div class="three wide field p-0" style="margin-left: 7px">
                  <div class="ui selection search multiple" id="search-client">
                    <div class="ui action icon input">
                      <i class="search icon"></i>
                      <input
                        class="prompt client_prompt_"
                        type="text"
                        placeholder="Client ..."
                        style="padding: 7px; border-radius: 0"
                      />
                      <input
                        v-model="client"
                        type="hidden"
                        name="client_id"
                        class="client_search_"
                      />
                      <div
                        class="ui basic red mini button"
                        style="border: 0; display: none"
                        id="close-client"
                      >
                        <i
                          class="close red icon"
                          style="
                            margin-right: 14px;
                            padding: 4px;
                            font-size: 19px;
                          "
                        ></i>
                      </div>
                    </div>
                    <div class="result"></div>
                  </div>
                </div>

                <div class="ten wide field">
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
      client: null,
      selected_statuts: [],
    };
  },
  mounted() {
    var _vm_pl = this;
    $(".ui.checkbox").checkbox();
    $("#search-client").search({
      apiSettings: {
        url: `/handle/select/client?search={query}&client`,
      },
      fields: {
        results: "results",
        title: "name",
        value: "value",
      },
      maxResults: 150,
      cache: false,
      clearable: true,
      searchOnFocus: true,
      onSelect: function (result) {
        _vm_pl.client = result.value;
        $("#close-client").css("display", "block");
        _vm_pl.loadPlanif();
      },
    });
    $("#close-client").on("click", function (e) {
      e.preventDefault();
      _vm_pl.client = null;
      $(".client_search_").val("");
      $(".client_prompt_").val("");
      $(`.client_search_`).change();
      $("#close-client").css("display", "none");
      _vm_pl.loadPlanif();
    });
    this.loadPlanif();
  },
  methods: {
    loadPlanif: function () {
      ajax_get(
        { client_id: this.client, statuts: this.selected_statuts },
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
