import React from "react";
import classNames from "classnames";
import { Link } from "@inertiajs/inertia-react";

export default function BlogCard({ blog, lettersCount = 200 }) {
    return (
        <Link
            href={route("blogs.show", blog)}
            className={classNames([
                "rounded-lg overflow-hidden transition-all hover:-translate-y-1 hover:scale-105 shadow bg-white",
                {
                    "p-4": !blog.cover,
                },
            ])}
        >
            {!!blog.cover ? (
                <div className="w-full h-40 bg-gray-300">
                    <img
                        src={blog.cover}
                        alt={blog.title}
                        className="object-cover w-full h-full object-fit"
                    />
                </div>
            ) : null}
            <div
                className={classNames({
                    "p-4": blog.cover,
                })}
            >
                <h3 className="mb-3 overflow-hidden text-lg font-bold text-ellipsis whitespace-nowrap">
                    {blog.title}
                </h3>
                <p>
                    {blog.body.length > lettersCount
                        ? blog.body.slice(0, lettersCount) + "..."
                        : blog.body}
                </p>
                <div className="mt-4 text-xs" v-if="blog.user">
                    <div className="flex items-center">
                        <div className="w-8 h-8 mr-2 overflow-hidden rounded-full">
                            <img
                                src={blog.user.profilePicture}
                                alt={blog.user.name}
                                className="object-cover object-center w-full h-full"
                            />
                        </div>
                        <strong>{blog.user.name}</strong>
                    </div>
                </div>
            </div>
        </Link>
    );
}
