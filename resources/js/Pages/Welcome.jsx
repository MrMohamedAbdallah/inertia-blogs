import React from "react";
import { Link, Head } from "@inertiajs/inertia-react";
import BaseLayout from "@/Layouts/BaseLayout";
import BlogsRow from "@/Components/BlogsRow";

export default function Welcome({ blogs }) {
    return (
        <>
            <Head title="Welcome" />
            <BaseLayout>
                <BlogsRow className="pb-10 mt-4" blogs={blogs} />
            </BaseLayout>
        </>
    );
}
