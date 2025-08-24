# 05. 기본 UI/UX 구현

## 🎯 목표
BookmarkHub의 일관된 디자인 시스템을 구축하고, 사용자 친화적인 기본 UI/UX를 완성합니다.

## 📋 요구사항
### 기능적 요구사항
- 전체 애플리케이션 레이아웃 구조
- 반응형 네비게이션 시스템
- 다크모드 지원
- 로딩 및 에러 상태 처리
- 접근성 (Accessibility) 준수
- 모바일 친화적 UI

### 기술적 요구사항
- shadcn/ui 컴포넌트 체계적 활용
- Tailwind CSS 커스텀 컬러 시스템
- TypeScript 기반 컴포넌트 props
- SEO 최적화된 메타 태그

## 🛠️ 구현 사항

### Design System

#### 색상 팔레트 정의
- [ ] Tailwind 커스텀 색상 설정
  ```typescript
  // tailwind.config.js
  theme: {
    extend: {
      colors: {
        bookmark: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          500: '#0ea5e9',
          600: '#0284c7',
          900: '#0c4a6e',
        },
        category: {
          // 카테고리용 색상 팔레트
        }
      }
    }
  }
  ```

#### 타이포그래피 시스템
- [ ] 글꼴 및 크기 체계 정의
  ```css
  /* resources/css/app.css */
  - 제목용 글꼴 (Inter, 700)
  - 본문용 글꼴 (Inter, 400, 500)
  - 코드용 글꼴 (JetBrains Mono)
  ```

### Layout Components

#### 메인 레이아웃
- [ ] AppLayout 컴포넌트 확장
  ```tsx
  // resources/js/layouts/AppLayout.tsx
  - 상단 네비게이션 바
  - 사이드바 (카테고리 목록)
  - 메인 콘텐츠 영역
  - 푸터
  - 반응형 토글 메뉴
  ```

#### 네비게이션 시스템
- [ ] Navigation 컴포넌트
  ```tsx
  // resources/js/components/Navigation.tsx
  - 로고 및 브랜딩
  - 주요 메뉴 항목
  - 사용자 프로필 드롭다운
  - 알림 벨 (나중에 구현)
  - 검색 바
  ```

- [ ] Sidebar 컴포넌트
  ```tsx
  // resources/js/components/Sidebar.tsx
  - 카테고리 목록
  - 북마크 통계
  - 빠른 액션 버튼들
  - 접기/펼치기 기능
  ```

- [ ] MobileMenu 컴포넌트
  ```tsx
  // resources/js/components/MobileMenu.tsx
  - 햄버거 메뉴
  - 모바일용 네비게이션
  - 사용자 메뉴
  ```

### UI Components

#### 피드백 컴포넌트
- [ ] Toast 알림 시스템
  ```tsx
  // resources/js/components/ui/Toast.tsx
  - 성공/에러/경고 메시지
  - 자동 사라짐 기능
  - 위치 조정 가능
  ```

- [ ] Loading 컴포넌트들
  ```tsx
  // resources/js/components/Loading/
  - Spinner.tsx (로딩 스피너)
  - Skeleton.tsx (스켈레톤 로딩)
  - PageLoading.tsx (페이지 로딩)
  ```

- [ ] EmptyState 컴포넌트
  ```tsx
  // resources/js/components/EmptyState.tsx
  - 빈 상태 일러스트레이션
  - 안내 메시지
  - 액션 버튼
  ```

#### 폼 컴포넌트
- [ ] FormField 컴포넌트
  ```tsx
  // resources/js/components/FormField.tsx
  - 라벨 및 에러 메시지 통합
  - 다양한 입력 타입 지원
  - 유효성 검증 상태 표시
  ```

- [ ] SearchInput 컴포넌트
  ```tsx
  // resources/js/components/SearchInput.tsx
  - 검색 아이콘
  - 자동 완성 기능 (기본)
  - 키보드 단축키 지원
  ```

#### 데이터 표시 컴포넌트
- [ ] Pagination 컴포넌트
  ```tsx
  // resources/js/components/Pagination.tsx
  - 페이지 번호 표시
  - 이전/다음 버튼
  - 페이지 점프 기능
  ```

- [ ] StatCard 컴포넌트
  ```tsx
  // resources/js/components/StatCard.tsx
  - 통계 수치 표시
  - 아이콘 및 색상 지원
  - 변화율 표시 (선택적)
  ```

### Pages Enhancement

#### 홈페이지 개선
- [ ] Dashboard 페이지 업데이트
  ```tsx
  // resources/js/pages/dashboard.tsx
  - 최근 북마크 목록
  - 카테고리별 통계
  - 빠른 액션 버튼들
  - 활동 피드 (기본)
  ```

#### 에러 페이지 구현
- [ ] 에러 페이지들
  ```tsx
  // resources/js/pages/errors/
  - 404.tsx (페이지 없음)
  - 403.tsx (접근 권한 없음)
  - 500.tsx (서버 에러)
  ```

### 테마 및 다크모드

#### 다크모드 구현
- [ ] 테마 컨텍스트 설정
  ```tsx
  // resources/js/contexts/ThemeContext.tsx
  - 라이트/다크 모드 토글
  - 시스템 설정 따르기
  - 로컬 스토리지 저장
  ```

- [ ] 다크모드 스타일 정의
  ```css
  // Tailwind dark: 클래스 체계적 적용
  - 모든 컴포넌트에 다크모드 스타일
  - 색상 대비 최적화
  - 아이콘 및 이미지 적응
  ```

### 접근성 (Accessibility)

#### 키보드 네비게이션
- [ ] 키보드 단축키 시스템
  ```tsx
  // resources/js/hooks/useKeyboardShortcuts.tsx
  - Ctrl+K: 검색 열기
  - Ctrl+N: 새 북마크
  - Esc: 모달 닫기
  ```

#### 스크린 리더 지원
- [ ] ARIA 속성 추가
  - aria-label, aria-describedby
  - role 속성 적절히 사용
  - 포커스 관리 시스템

#### 색상 대비 및 텍스트 크기
- [ ] WCAG 2.1 AA 준수
  - 최소 4.5:1 색상 대비
  - 텍스트 크기 조정 가능
  - 호버/포커스 상태 명확히

## 📁 파일 구조
```
resources/js/
├── components/
│   ├── ui/ (shadcn/ui 기본 컴포넌트)
│   ├── Navigation.tsx
│   ├── Sidebar.tsx
│   ├── MobileMenu.tsx
│   ├── EmptyState.tsx
│   ├── FormField.tsx
│   ├── SearchInput.tsx
│   ├── StatCard.tsx
│   └── Loading/
│       ├── Spinner.tsx
│       ├── Skeleton.tsx
│       └── PageLoading.tsx
├── contexts/
│   └── ThemeContext.tsx
├── hooks/
│   ├── useKeyboardShortcuts.tsx
│   └── useTheme.tsx
├── layouts/
│   └── AppLayout.tsx (확장)
├── pages/
│   ├── dashboard.tsx (업데이트)
│   └── errors/
│       ├── 404.tsx
│       ├── 403.tsx
│       └── 500.tsx
└── styles/
    └── globals.css (다크모드 스타일)

resources/css/
└── app.css (타이포그래피 및 기본 스타일)

tailwind.config.js (색상 팔레트 확장)
```

## ✅ 완료 기준
- [ ] 모든 페이지가 일관된 레이아웃 사용
- [ ] 반응형 디자인 (모바일, 태블릿, 데스크톱)
- [ ] 다크모드 완전 지원
- [ ] 키보드 네비게이션 가능
- [ ] WCAG 2.1 AA 접근성 기준 충족
- [ ] 로딩 상태 및 에러 처리 UI 구현
- [ ] 빈 상태에 대한 적절한 안내
- [ ] 토스트 알림 시스템 작동
- [ ] 모든 인터랙션에 시각적 피드백

## 🧪 테스트
### 접근성 테스트
- [ ] 스크린 리더 테스트 (NVDA, JAWS)
- [ ] 키보드 전용 네비게이션 테스트
- [ ] 색상 대비 체크 (WebAIM)
- [ ] 포커스 표시 확인

### 반응형 테스트
- [ ] 모바일 (320px-768px) 레이아웃
- [ ] 태블릿 (768px-1024px) 레이아웃  
- [ ] 데스크톱 (1024px+) 레이아웃
- [ ] 터치 인터랙션 테스트

### 브라우저 호환성
- [ ] Chrome/Edge (최신 2버전)
- [ ] Firefox (최신 2버전)
- [ ] Safari (최신 2버전)
- [ ] 모바일 브라우저 테스트

### 성능 테스트
- [ ] Lighthouse 성능 점수 85+
- [ ] 첫 페이지 로딩 시간 < 2초
- [ ] 다크모드 전환 부드러움
- [ ] 애니메이션 성능 확인

## 📚 참고자료
- [shadcn/ui Components](https://ui.shadcn.com/docs/components)
- [Tailwind CSS Dark Mode](https://tailwindcss.com/docs/dark-mode)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [React Accessibility](https://react.dev/learn/accessibility)
- [Lighthouse Performance](https://developers.google.com/web/tools/lighthouse)

---
**상태**: 📝 계획  
**예상 소요 시간**: 6-8일  
**담당자**: 프론트엔드/디자인팀  
**우선순위**: 높음  
**의존성**: 01-04 모든 이전 태스크