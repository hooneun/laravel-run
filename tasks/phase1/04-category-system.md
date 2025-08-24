# 04. 카테고리 관리 시스템

## 🎯 목표
북마크를 체계적으로 분류할 수 있는 카테고리 시스템을 구현하여 사용자가 북마크를 효율적으로 관리할 수 있도록 합니다.

## 📋 요구사항
### 기능적 요구사항
- 사용자별 카테고리 생성/수정/삭제
- 북마크와 카테고리 연결
- 카테고리별 북마크 조회
- 카테고리 색상 지정 기능
- 카테고리별 공개/비공개 설정
- 미분류 카테고리 자동 생성

### 기술적 요구사항
- 카테고리 소유권 검증
- 북마크-카테고리 관계 설정
- 카테고리 삭제 시 북마크 처리
- 카테고리별 통계 정보

## 🛠️ 구현 사항

### Backend

#### 모델 생성
- [ ] Category 모델 및 마이그레이션 생성
  ```php
  // app/Models/Category.php
  Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('name', 100);
      $table->string('description', 500)->nullable();
      $table->string('color', 7)->default('#6366f1'); // hex color
      $table->string('icon', 50)->nullable(); // lucide icon name
      $table->boolean('is_public')->default(true);
      $table->integer('bookmarks_count')->default(0);
      $table->integer('sort_order')->default(0);
      $table->timestamps();
      
      $table->unique(['user_id', 'name']); // 같은 사용자는 중복 카테고리명 불가
      $table->index(['user_id', 'sort_order']);
  });
  ```

- [ ] Bookmark 모델에 카테고리 관계 추가
  ```php
  // database/migrations/xxxx_add_category_to_bookmarks_table.php
  $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
  $table->index(['category_id', 'created_at']);
  ```

#### 컨트롤러 생성
- [ ] CategoryController 생성
  ```php
  // app/Http/Controllers/CategoryController.php
  - index() - 카테고리 목록 (정렬 순서대로)
  - create() - 카테고리 생성 폼
  - store() - 카테고리 저장
  - show() - 카테고리별 북마크 목록
  - edit() - 카테고리 수정 폼
  - update() - 카테고리 업데이트
  - destroy() - 카테고리 삭제
  - reorder() - 카테고리 순서 변경
  ```

#### 폼 요청 클래스 생성
- [ ] 카테고리 검증 클래스
  ```php
  // app/Http/Requests/StoreCategoryRequest.php
  - 이름 필수 및 길이 제한 (100자)
  - 같은 사용자 내 이름 중복 체크
  - 색상 hex 형식 검증
  - 아이콘 이름 검증
  
  // app/Http/Requests/UpdateCategoryRequest.php
  - 기본 필드 검증
  - 소유권 검증
  ```

#### 서비스 클래스 생성
- [ ] CategoryService 생성
  ```php
  // app/Services/CategoryService.php
  - createDefaultCategory($user) - 기본 카테고리 생성
  - updateBookmarkCounts($categoryId) - 북마크 수 업데이트
  - reorderCategories($user, $orders) - 카테고리 순서 변경
  - deleteWithBookmarks($category, $moveToCategory = null) - 카테고리 삭제 시 북마크 처리
  ```

#### 정책 클래스 생성
- [ ] CategoryPolicy 생성
  ```php
  // app/Policies/CategoryPolicy.php
  - view() - 카테고리 조회 권한
  - create() - 카테고리 생성 권한
  - update() - 카테고리 수정 권한
  - delete() - 카테고리 삭제 권한
  ```

### Frontend

#### 타입 정의
- [ ] 카테고리 관련 타입 정의
  ```typescript
  // resources/js/types/index.ts
  interface Category {
    id: number;
    user_id: number;
    name: string;
    description?: string;
    color: string;
    icon?: string;
    is_public: boolean;
    bookmarks_count: number;
    sort_order: number;
    created_at: string;
    updated_at: string;
    user?: User;
  }
  
  interface CategoryForm {
    name: string;
    description?: string;
    color: string;
    icon?: string;
    is_public: boolean;
  }
  ```

#### 페이지 컴포넌트 생성
- [ ] 카테고리 관리 페이지
  ```tsx
  // resources/js/pages/categories/index.tsx
  - 카테고리 목록 (드래그 앤 드롭 정렬)
  - 카테고리별 북마크 수 표시
  - 빠른 생성 버튼
  ```

- [ ] 카테고리 생성/수정 페이지
  ```tsx
  // resources/js/pages/categories/form.tsx
  - 카테고리 이름 입력
  - 색상 선택기
  - 아이콘 선택기
  - 공개 설정 토글
  ```

- [ ] 카테고리별 북마크 목록 페이지
  ```tsx
  // resources/js/pages/categories/show.tsx
  - 카테고리 정보 헤더
  - 해당 카테고리의 북마크 목록
  - 북마크 추가/이동 기능
  ```

#### UI 컴포넌트 생성
- [ ] CategoryCard 컴포넌트
  ```tsx
  // resources/js/components/CategoryCard.tsx
  - 카테고리 색상 및 아이콘
  - 카테고리 이름과 설명
  - 북마크 수 표시
  - 액션 버튼 (편집, 삭제)
  ```

- [ ] CategorySelect 컴포넌트
  ```tsx
  // resources/js/components/CategorySelect.tsx
  - 북마크 생성/수정 시 카테고리 선택
  - 색상 및 아이콘으로 시각적 구분
  - 새 카테고리 빠른 생성
  ```

- [ ] ColorPicker 컴포넌트
  ```tsx
  // resources/js/components/ColorPicker.tsx
  - 사전 정의된 색상 팔레트
  - 커스텀 색상 입력
  - 색상 미리보기
  ```

- [ ] IconPicker 컴포넌트
  ```tsx
  // resources/js/components/IconPicker.tsx
  - Lucide 아이콘 그리드
  - 아이콘 검색 기능
  - 선택된 아이콘 미리보기
  ```

## 📁 파일 구조
```
app/
├── Http/
│   ├── Controllers/
│   │   └── CategoryController.php
│   └── Requests/
│       ├── StoreCategoryRequest.php
│       └── UpdateCategoryRequest.php
├── Models/
│   ├── Category.php
│   └── Bookmark.php (수정)
├── Policies/
│   └── CategoryPolicy.php
└── Services/
    └── CategoryService.php

database/
└── migrations/
    ├── xxxx_create_categories_table.php
    └── xxxx_add_category_to_bookmarks_table.php

resources/js/
├── components/
│   ├── CategoryCard.tsx
│   ├── CategorySelect.tsx
│   ├── ColorPicker.tsx
│   ├── IconPicker.tsx
│   └── ui/ (기존)
├── pages/
│   ├── categories/
│   │   ├── index.tsx
│   │   ├── form.tsx
│   │   └── show.tsx
│   └── bookmarks/ (기존)
└── types/
    └── index.ts (수정)

routes/
└── web.php (카테고리 라우트 추가)

tests/
├── Feature/
│   └── CategoryTest.php
└── Unit/
    ├── CategoryModelTest.php
    └── CategoryServiceTest.php
```

## ✅ 완료 기준
- [ ] 카테고리 CRUD 기능 완성
- [ ] 북마크 생성 시 카테고리 선택 가능
- [ ] 카테고리별 북마크 목록 조회 가능
- [ ] 카테고리 순서 변경 기능 (드래그 앤 드롭)
- [ ] 카테고리 색상 및 아이콘 설정 기능
- [ ] 카테고리 삭제 시 북마크 처리 로직
- [ ] 미분류 카테고리 자동 생성
- [ ] 카테고리별 공개/비공개 설정
- [ ] 반응형 UI 구현

## 🧪 테스트
### Backend 테스트
- [ ] 카테고리 CRUD 기능 테스트
- [ ] 북마크-카테고리 관계 테스트
- [ ] 카테고리 순서 변경 테스트
- [ ] 카테고리 삭제 시 북마크 처리 테스트
- [ ] 권한 검증 테스트

### Frontend 테스트
- [ ] 카테고리 폼 제출 테스트
- [ ] 색상/아이콘 선택기 테스트
- [ ] 드래그 앤 드롭 정렬 테스트
- [ ] 카테고리 선택 컴포넌트 테스트

### E2E 테스트
- [ ] 카테고리 생성 전체 플로우
- [ ] 북마크 카테고리 지정 플로우
- [ ] 카테고리별 북마크 조회 플로우
- [ ] 카테고리 순서 변경 플로우

## 📚 참고자료
- [Laravel Eloquent Relationships](https://laravel.com/docs/11.x/eloquent-relationships)
- [React DnD](https://react-dnd.github.io/react-dnd/) - 드래그 앤 드롭
- [React Color](https://casesandberg.github.io/react-color/) - 색상 선택기
- [Lucide React](https://lucide.dev/guide/packages/lucide-react) - 아이콘
- [HTML Color Codes](https://htmlcolorcodes.com/)

---
**상태**: 📝 계획  
**예상 소요 시간**: 4-5일  
**담당자**: 백엔드/프론트엔드 개발팀  
**우선순위**: 높음  
**의존성**: 03-bookmark-crud.md