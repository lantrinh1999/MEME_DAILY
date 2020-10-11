<template>
    <div v-if="$page.flash.success == 1">
        <div class="content content py-1 my-1">
            <div
                v-if="$page.flash.success == 1"
                class="alert bg-success text-white alert-styled-left alert-dismissible"
            >
                <button type="button" class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <span class="font-weight-semibold"></span>
                <span v-html="$page.flash.success"></span>
            </div>

            <div
                v-if="$page.flash.error == 1"
                class="alert bg-danger text-white alert-styled-left alert-dismissible"
            >
                <button type="button" class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <span class="font-weight-semibold"></span>
                <span v-html="$page.flash.error"></span>
            </div>
        </div>
    </div>
</template>

<script>

import "@dmuy/toast/dist/mdtoast.css";
import mdtoast from "@dmuy/toast";

export default {
    watch: {
        $page: function (value) {
            if (this.$page.flash.success != null) {
                console.log(this.$page);
                mdtoast(
                    '<i class="fa fa-check mr-2"></i> ' + this.$page.flash.success,
                    {
                        type: "success",
                        //   interaction: true,
                        duration: 3456,
                        //   actionText: "undo",
                        action: function () {
                            //TODO: Undo codes here...
                            this.hide(); // this is the toast instance
                        },
                    }
                );
            }
            if (this.$page.flash.error != null) {
                mdtoast(
                    '<i class="fa fa-exclamation" aria-hidden="true mr-2"></i> ' +
                    this.$page.flash.error,
                    {
                        type: "error",
                        //   interaction: true,
                        duration: 3456,
                        //   actionText: "undo",
                        action: function () {
                            //TODO: Undo codes here...
                            this.hide(); // this is the toast instance
                        },
                    }
                );
            }
        },
    },
};
</script>

<style>
/*!Don't remove this!
 * Material-Toast plugin styles
 *
 * Author: Dionlee Uy
 * Email: dionleeuy@gmail.com
 */


.mdtoast {
    position: fixed;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    box-sizing: border-box;
    left: 24px;
    bottom: 24px;
    padding: 0 24px;
    color: #fff;
    font-family: Roboto, sans-serif;
    font-size: 16px;
    text-align: left;
    outline: none;
    pointer-events: auto;
    touch-action: auto;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: #323232;
    transform: translateY(0);
    transition: transform 0.23s 0ms cubic-bezier(0, 0, 0.2, 1);
    will-change: transform;
    z-index: 100002;
}

.mdtoast .mdt-message {
    display: flex;
    align-items: center;
    min-height: 48px;
    padding: 8px 0;
    opacity: 1;
    margin-left: 0;
    box-sizing: border-box;
    transition: opacity 0.3s 0ms cubic-bezier(0.4, 0, 1, 1);
}

.mdtoast .mdt-message::after {
    content: '';
    min-height: 32px;
    font-size: 0;
}

.mdtoast .mdt-action {
    display: flex;
    align-items: center;
    color: #ffeb3b;
    text-decoration: none;
    cursor: pointer;
    letter-spacing: 0.07em;
    font-weight: 500;
    padding: 8px;
    margin: 0 0 0 24px;
    opacity: 1;
    min-height: 32px;
    background: none;
    border: none;
    outline: none;
    box-sizing: border-box;
    border-radius: 4px;
    transition: opacity 0.3s 0ms cubic-bezier(0.4, 0, 1, 1), background-color 0.15s linear;
}

.mdtoast .mdt-action:focus, .mdtoast .mdt-action:hover {
    background-color: rgba(255, 255, 255, 0.075);
}

.mdtoast .mdt-action:active {
    background-color: rgba(255, 255, 255, 0.15);
}

.mdtoast.mdt--load {
    transform: translateY(200%);
    transition: transform 0.23s 0ms cubic-bezier(0.4, 0, 1, 1);
}

.mdtoast.mdt--load .mdt-message {
    opacity: 0;
}

.mdtoast.mdt--load .mdt-action {
    opacity: 0;
}

.mdtoast.mdt--interactive {
    padding-right: 16px;
}

.mdtoast.mdt--interactive .mdt-message {
    margin-right: auto;
}

.mdtoast.mdt--info {
    background-color: #1565c0;
}

.mdtoast.mdt--error {
    background-color: #e53935;
}

.mdtoast.mdt--warning {
    background-color: #ef6c00;
}

.mdtoast.mdt--success {
    background-color: #2e7d32;
}

@media (min-width: 600px) {
    .mdtoast {
        min-width: 288px;
        max-width: 568px;
        border-radius: 4px;
    }
}

@media (max-width: 599px) {
    .mdtoast {
        left: 0;
        bottom: 0;
        right: 0;
        font-size: 14px;
        max-width: 100%;
        transform: translateY(0);
    }

    .mdtoast.mdt--load {
        transform: translateY(100%);
    }
}

body.mdtoast--modal {
    pointer-events: none;
    touch-action: none;
    -ms-user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}

.alert {
    margin-bottom: 0;
}

.mdtoast {
    left: auto !important;
    right: 20px !important;
}

.mdtoast .mdt-action {
    font-weight: 400 !important;
    font-size: 14px !important;
    color: beige !important;
}
</style>
