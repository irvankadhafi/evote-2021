<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <p class="mb-8 leading-normal">Welcome {{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }} to E-Vote HMJTK Dashboard</p>
    <p class="mb-8 leading-normal">Kamu Login Sebagai {{ $page.props.auth.user.owner ? 'Admin/Panitia': 'Saksi' }}</p>
  </div>
</template>

<script>
import Layout from '../../Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
}
</script>
