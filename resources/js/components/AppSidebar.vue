<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard, enumerations, asset, reports, users, roles } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, DollarSignIcon, LayoutGrid, LockKeyhole, UserCog, Car, Ship, Map, HelpCircleIcon, HeadphonesIcon} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Cars',
        href: enumerations(),
        icon: Car,
    },
    {
        title: 'Shipments',
        href: '/map',
        icon: Ship,
    },
    {
        title: 'Tracking',
        href: asset(),
        icon: Map,
    },
    {
        title: 'Payments',
        href: '#',
        icon: DollarSignIcon,
    },
    
    {
        title: 'Reports',
        href: reports(),
        icon: BookOpen,
    },
    {
        title: 'Help & Support',
        href: '#',
        icon: HeadphonesIcon,
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Access Control',
        href: users(),
        icon: LockKeyhole,
    },
    {
        title: 'Roles & Permissions',
        href: roles(),
        icon: UserCog,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
