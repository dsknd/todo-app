<?php

namespace Tests\Helpers;

use App\Models\Permission;
use App\Models\PermissionClosure;
use Database\Factories\PermissionClosureFactory;

class PermissionHierarchySetup
{
    /**
     * 単純な親子関係を設定
     *
     * @param Permission $parent
     * @param Permission $child
     * @return void
     */
    public static function setupParentChild(Permission $parent, Permission $child): void
    {
        // 親の自己参照
        PermissionClosure::factory()->selfReference($parent)->create();
        
        // 親と子の関係（深さ1）
        PermissionClosure::factory()->parentChild($parent, $child)->create();
        
        // 子の自己参照
        PermissionClosure::factory()->selfReference($child)->create();
    }
    
    /**
     * 複数の子を持つ親を設定
     *
     * @param Permission $parent
     * @param array<Permission> $children
     * @return void
     */
    public static function setupParentWithChildren(Permission $parent, array $children): void
    {
        // 親の自己参照
        PermissionClosure::factory()->selfReference($parent)->create();
        
        foreach ($children as $child) {
            // 親と子の関係（深さ1）
            PermissionClosure::factory()->parentChild($parent, $child)->create();
            
            // 子の自己参照
            PermissionClosure::factory()->selfReference($child)->create();
        }
    }
    
    /**
     * 階層構造をセットアップ（root -> parent -> child）
     *
     * @param Permission $root
     * @param Permission $parent
     * @param Permission $child
     * @return void
     */
    public static function setupThreeLevelHierarchy(
        Permission $root,
        Permission $parent,
        Permission $child
    ): void {
        // 自己参照
        PermissionClosure::factory()->selfReference($root)->create();
        PermissionClosure::factory()->selfReference($parent)->create();
        PermissionClosure::factory()->selfReference($child)->create();
        
        // 直接の親子関係
        PermissionClosure::factory()->parentChild($root, $parent)->create();
        PermissionClosure::factory()->parentChild($parent, $child)->create();
        
        // ルートと孫の関係（深さ2）
        PermissionClosure::factory()
            ->withAncestor($root)
            ->withDescendant($child)
            ->withDepth(2)
            ->create();
    }
} 