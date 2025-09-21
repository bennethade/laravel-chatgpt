<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

// Hold the AI response
const aiResponse = ref<string>("Loading...");

declare global {
  interface Window {
    puter: any;
  }
}

onMounted(() => {
  // Dynamically inject script if not already loaded
  if (!document.querySelector('script[src="https://js.puter.com/v2/"]')) {
    const s = document.createElement('script');
    s.src = "https://js.puter.com/v2/";
    s.defer = true;
    s.onload = () => {
      // ✅ Now safe to use puter
      if (window.puter) {
        window.puter.ai.chat("What are the benefits of exercise?", { model: "gpt-5-nano" })
          .then((response: any) => {
            // Save response into Vue state
            aiResponse.value = response;
          })
          .catch((err: any) => {
            aiResponse.value = "Error: " + err.message;
          });
      } else {
        aiResponse.value = "Puter not loaded.";
      }
    };
    document.head.appendChild(s);
  }
});
</script>

<template>
  <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
    <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
      <nav class="flex items-center justify-end gap-4">
        <Link v-if="$page.props.auth.user" href="/chat" class="inline-block rounded-sm border px-5 py-1.5">Chat</Link>
        <Link v-if="$page.props.auth.user" :href="dashboard()" class="inline-block rounded-sm border px-5 py-1.5">Dashboard</Link>

        <template v-else>
          <Link :href="login()" class="inline-block rounded-sm border px-5 py-1.5">Log in</Link>
          <Link :href="register()" class="inline-block rounded-sm border px-5 py-1.5">Register</Link>
        </template>
      </nav>
    </header>

    <div class="flex w-full items-center justify-center lg:grow">
      <!-- AI response shows here -->
      <div id="puter-output" class="max-w-lg text-center p-4 rounded bg-white dark:bg-[#1b1b1b] shadow">
        {{ aiResponse }}
      </div>
    </div>
  </div>
</template>
